<?php

namespace Jojotique\JWT\Resources;

use Jojotique\JWT\Exception\TokenException;
use Jojotique\JWT\Resources\Interfaces\JsonWebTokenInterface;
use Jojotique\JWT\Resources\Interfaces\JWTApiAuthorizationInterface;
use Jojotique\JWT\Resources\Interfaces\JWTValidationHelperInterface;

class JWTApiAuthorization implements JWTApiAuthorizationInterface
{
    /**
     * @var JWTValidationHelperInterface
     */
    private JWTValidationHelperInterface $JWTValidationHelper;

    /**
     * JWTApiAuthorization constructor.
     *
     * @param JWTValidationHelperInterface $JWTValidationHelper
     */
    public function __construct(JWTValidationHelperInterface $JWTValidationHelper)
    {
        $this->JWTValidationHelper = $JWTValidationHelper;
    }

    /**
     * @inheritDoc
     */
    public function authorization(?string $authorization): JsonWebTokenInterface
    {
        $jwt = null;
        preg_match('#^Bearer (.*)$#', $authorization, $jwt);

        if (empty($jwt)) {
            throw new JWTException(
                'Authorization header required.',
                TokenException::UNAUTHORIZED
            );
        }

        $jwt = $this->JWTValidationHelper->valid($jwt[1]);

        if ($jwt->isRefresh()) {
            throw new JWTException(
                'The token has to be a access token.',
                TokenException::TOKEN_HAS_TO_BE_ACCESS
            );
        }

        return $jwt;
    }
}