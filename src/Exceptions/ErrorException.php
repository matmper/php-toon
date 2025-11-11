<?php

namespace Matmper\Exceptions;

use Exception;
use Throwable;

class ValueException extends Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable|null $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
