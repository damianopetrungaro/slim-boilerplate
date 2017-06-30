<?php

declare(strict_types=1);

namespace App\Acme\JWT;

use App\Exceptions\JWTException;
use BadMethodCallException;
use InvalidArgumentException;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;
use RuntimeException;
use Slim\Http\Request;

class JWT
{
    /**
     * @var string
     */
    private $token;
    /**
     * @var Sha256
     */
    private $sha256;
    /**
     * @var Parser
     */
    private $parser;
    /**
     * @var Builder
     */
    private $builder;
    /**
     * @var ValidationData
     */
    private $validator;
    /**
     * @var array
     */
    private $config = [];

    /**
     * JWT constructor.
     *
     * @param Request $request
     * @param Builder $builder
     * @param Sha256 $sha256
     * @param Parser $parser
     * @param ValidationData $validator
     * @param array $config
     */
    public function __construct(Request $request, Builder $builder, Sha256 $sha256, Parser $parser, ValidationData $validator, array $config)
    {
        $this->config = $config;
        $this->sha256 = $sha256;
        $this->parser = $parser;
        $this->builder = $builder;
        $this->token = $request->getHeaderLine($this->config['header-param']);
        $this->validator = $validator;
    }

    /**
     * Return an encoded jwt
     *
     * @param array $data
     *
     * @return string
     */
    public function encode(array $data): string
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

    /**
     * Decode the token and return its content
     *
     * @return array
     *
     * @throws JWTException
     */
    public function decode(): array
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
