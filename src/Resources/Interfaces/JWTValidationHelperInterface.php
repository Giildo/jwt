<?php

namespace Jojotique\JWT\Resources\Interfaces;

use Jojotique\JWT\Resources\JWTException;

interface JWTValidationHelperInterface
{
    /**
     * Valides the JWT
     *
     * @param string $jwt
     *
     * @return JsonWebTokenInterface
     * @throws JWTException
     */
    public function valid(string $jwt): JsonWebTokenInterface;
}