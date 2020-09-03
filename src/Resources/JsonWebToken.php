<?php

namespace Jojotique\JWT\Resources;

use Jojotique\JWT\Resources\Interfaces\JsonWebTokenInterface;

class JsonWebToken implements JsonWebTokenInterface
{
    /**
     * @var string
     */
    private string $header;
    /**
     * @var string
     */
    private string $payload;
    /**
     * @var string
     */
    private string $signature;
    /**
     * @var string
     */
    private string $type;
    /**
     * @var int
     */
    private int $iat;
    /**
     * @var int
     */
    private int $exp;
    /**
     * @var string
     */
    private string $uid;

    /**
     * JsonWebToken constructor.
     *
     * @param string $jwt
     */
    public function __construct(string $jwt)
    {
        $jwtArray = preg_split('/\./', $jwt);
        $this->header = $jwtArray[0];
        $this->payload = $jwtArray[1];
        $this->signature = $jwtArray[2];

        $payload = json_decode(base64_decode($this->payload));
        $this->type = $payload->type;
        $this->iat = $payload->iat;
        $this->exp = $payload->exp;
        $this->uid = $payload->uid;
    }

    /**
     * @inheritDoc
     */
    public function isAccess(): bool
    {
        return $this->type === 'access';
    }

    /**
     * @inheritDoc
     */
    public function isRefresh(): bool
    {
        return $this->type === 'refresh';
    }

    /**
     * @inheritDoc
     */
    public function isValid(): bool
    {
        $signature = hash_hmac(
            'sha512',
            $this->header . "." . $this->payload,
            $_ENV['JWT_SECRET_PASS'],
            true
        );

        return $this->signature === str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
    }

    /**
     * @inheritDoc
     */
    public function isExpired(): bool
    {
        return time() > $this->exp;
    }

    /**
     * @inheritDoc
     */
    public function getUid(): string
    {
        return $this->uid;
    }

    /**
     * @inheritDoc
     */
    public function getToken(): string
    {
        return "{$this->header}.{$this->payload}.{$this->signature}";
    }
}
