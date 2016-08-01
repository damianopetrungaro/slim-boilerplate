<?php

namespace App\Acme\JWT;

use RuntimeException;
use Slim\Http\Request;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Builder;
use BadMethodCallException;
use InvalidArgumentException;
use App\Exceptions\JWTException;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class JWT
{
    private $token;
    private $sha256;
    private $parser;
    private $builder;
    private $validator;
    private $config = [];

    public function __construct(Request $request, Builder $builder, Sha256 $sha256, Parser $parser, ValidationData $validator, array $config)
    {
        $this->config = $config;
        $this->sha256 = $sha256;
        $this->parser = $parser;
        $this->builder = $builder;
        $this->token = $request->getHeaderLine($this->config['header-param']);
        $this->validator = $validator;
    }

    public function encode(array $data)
    {
        $token = $this->builder->setIssuer($this->config['issuer'])
            ->setAudience($this->config['audience'])
            ->setId($this->config['id'], true)
            ->setIssuedAt(time())
            ->setNotBefore(time())
            ->setExpiration(time() + 3600);
        foreach ($data as $key => $value) {
            $token->set($key, $value);
        }
        $token->sign($this->sha256, $this->config['sign']);

        return $token->getToken()->__toString();
    }

    public function decode()
    {
        try {
            $token = $this->parser->parse($this->token);
            $this->validator->setIssuer($this->config['issuer']);
            $this->validator->setAudience($this->config['audience']);
            $this->validator->setId($this->config['id']);
            if (!$token->validate($this->validator)) {
                throw new JWTException('Invalid Token', 'Error validating the token');
            }
            if (!$token->verify($this->sha256, $this->config['sign'])) {
                throw new JWTException('Invalid Token', 'The token is empty or not encrypted correctly');
            }
            
            return $token->getClaims();
        } catch (InvalidArgumentException $e) {
            throw new JWTException('Invalid Token', $e->getMessage(), $e->getCode());
        } catch (BadMethodCallException $e) {
            throw new JWTException('Parsing Error', $e->getMessage(), $e->getCode());
        } catch (RuntimeException $e) {
            throw new JWTException('Parsing Error', $e->getMessage(), $e->getCode());
        }
    }
}
