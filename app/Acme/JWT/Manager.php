<?php

namespace App\Acme\JWT;

use RuntimeException;
use Slim\Http\Request;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Builder;
use BadMethodCallException;
use InvalidArgumentException;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class Manager
{
	public $token;
	// private $token; MUST USE THIS
	private $config = [];

	public function __construct(Request $request, array $config)
	{
		$this->config = $config;
		$this->token = $request->getHeaderLine($this->config['header-param']);
	}

	public function encode(array $data)
	{
		$token = (new Builder())->setIssuer($this->config['issuer'])
			->setAudience($this->config['audience'])
			->setId($this->config['id'], true)
			->setIssuedAt(time())
			->setNotBefore(time())
			->setExpiration(time() + 3600);
		foreach ($data as $key => $value) {
			$token->set($key, $value);
		}
		$token->sign(new Sha256(), $this->config['sign']);

		return $token->getToken()->__toString();
	}

	public function decode()
	{
		try {
			$token = (new Parser())->parse($this->token);
			$validationData = new ValidationData();
			$validationData->setIssuer($this->config['issuer']);
			$validationData->setAudience($this->config['audience']);
			$validationData->setId($this->config['id']);
			if (!$token->validate($validationData)) {
				return false;
			}
			if (!$token->verify(new Sha256(), $this->config['sign'])) {
				return false;
			}

			return $token->getClaims();
		} catch (InvalidArgumentException $e) {
			throw new Exception('Invalid Token', $e->getMessage(), $e->getCode());
		} catch (BadMethodCallException $e) {
			throw new Exception('Parsing Error', $e->getMessage(), $e->getCode());
		} catch (RuntimeException $e) {
			throw new Exception('Parsing Error', $e->getMessage(), $e->getCode());
		}
	}
}