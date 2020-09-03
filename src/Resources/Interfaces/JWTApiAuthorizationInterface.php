<?php

namespace Jojotique\JWT\Resources\Interfaces;

use Jojotique\JWT\Resources\JWTException;

interface JWTApiAuthorizationInterface
{
    /**
     * @param string|null $authorization
     *
     * @return JsonWebTokenInterface
     * @throws JWTException
     */
    public function authorization(?string $authorization): JsonWebTokenInterface;
}