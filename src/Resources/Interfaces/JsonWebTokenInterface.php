<?php

namespace Jojotique\JWT\Resources\Interfaces;

interface JsonWebTokenInterface
{
    /**
     * Returns if the JWT is access JWT.
     *
     * @return bool
     */
    public function isAccess(): bool;

    /**
     * Returns if the JWT is refresh JWT.
     *
     * @return bool
     */
    public function isRefresh(): bool;

    /**
     * Returns if the JWT signature is valid.
     *
     * @return bool
     */
    public function isValid(): bool;

    /**
     * Returns if the JWT is expired.
     *
     * @return bool
     */
    public function isExpired(): bool;

    /**
     * Returns the user Uuid.
     *
     * @return string
     */
    public function getUid(): string;

    /**
     * Returns the JWT to string.
     *
     * @return string
     */
    public function getToken(): string;
}