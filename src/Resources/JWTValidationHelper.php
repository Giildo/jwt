<?php

namespace Jojotique\JWT\Resources;

use Jojotique\JWT\Exception\TokenException;
use Jojotique\JWT\Resources\Interfaces\JsonWebTokenInterface;
use Jojotique\JWT\Resources\Interfaces\JWTValidationHelperInterface;

class JWTValidationHelper implements JWTValidationHelperInterface
{
    /**
     * @inheritDoc
     */
    public function valid(string $jwt): JsonWebTokenInterface
    {
        $jwt = new JsonWebToken($jwt);

        if (!$jwt->isValid()) {
            throw new JWTException(
                'JWT no valid.',
                TokenException::TOKEN_INVALID
            );
        }

        if ($jwt->isExpired()) {
            throw new JWTException(
                'JWT expired.',
                TokenException::TOKEN_EXPIRED
            );
        }

        return $jwt;
    }
}