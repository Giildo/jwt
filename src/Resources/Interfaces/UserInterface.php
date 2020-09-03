<?php

namespace Jojotique\JWT\Resources\Interfaces;

use Ramsey\Uuid\UuidInterface;

interface UserInterface
{
    public function getId(): UuidInterface;
}