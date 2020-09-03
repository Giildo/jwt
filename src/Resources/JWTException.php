<?php

namespace Jojotique\JWT\Resources;

use Exception;
use Jojotique\Api\Domain\Output\Interfaces\OutInterface;

class JWTException extends Exception implements OutInterface
{
    /**
     * @var array|null
     */
    private ?array $errors;

    /**
     * ExceptionOutput constructor.
     *
     * @param string     $message
     * @param int        $code
     * @param array|null $errors
     */
    public function __construct(
        string $message,
        int $code,
        ?array $errors = []
    ) {
        $this->message = $message;
        $this->errors = $errors;
        parent::__construct($message, $code, null);
    }
}
