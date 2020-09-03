<?php

namespace Jojotique\JWT\Resources;

use Jojotique\JWT\Resources\Interfaces\JsonWebTokenInterface;
use Jojotique\JWT\Resources\Interfaces\JWTBuilderInterface;
use Jojotique\JWT\Resources\Interfaces\UserInterface;

class JWTBuilder implements JWTBuilderInterface
{
    /**
     * @var JsonWebTokenInterface
     */
    private JsonWebTokenInterface $jwt;

    /**
     * @inheritDoc
     */
    public function build(
        UserInterface $user,
        string $type,
        int $timestamp
    ): JWTBuilderInterface {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS512']);
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

        $timestampExp = $type === 'access'
            ? $timestamp + $_ENV['JWT_ACCESS_EXPIRATION']
            : $timestamp + $_ENV['JWT_REFRESH_EXPIRATION'];
        $payload = json_encode(
            [
                'type' => $type,
                'iat'  => $timestamp,
                'exp'  => $timestampExp,
                'uid'  => $user->getId()->toString(),
            ]
        );
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $signature = hash_hmac(
            'sha512',
            $base64UrlHeader . "." . $base64UrlPayload,
            $_ENV['JWT_SECRET_PASS'],
            true
        );
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        $this->jwt = new JsonWebToken("{$base64UrlHeader}.{$base64UrlPayload}.{$base64UrlSignature}");

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getJwt(): JsonWebTokenInterface
    {
        return $this->jwt;
    }
}
