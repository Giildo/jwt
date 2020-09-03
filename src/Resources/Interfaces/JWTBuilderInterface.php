<?php

namespace Jojotique\JWT\Resources\Interfaces;

interface JWTBuilderInterface
{
    /**
     * @param UserInterface $user
     * @param string             $type
     * @param int                $timestamp
     *
     * @return JWTBuilderInterface
     */
    public function build(
        UserInterface $user,
        string $type,
        int $timestamp
    ): self;

    /**
     * @return JsonWebTokenInterface
     */
    public function getJwt(): JsonWebTokenInterface;
}