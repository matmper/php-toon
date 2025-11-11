<?php

namespace Matmper\Exceptions;

use InvalidArgumentException as InvalidArgumentExceptionClass;
use Throwable;

class InvalidArgumentException extends InvalidArgumentExceptionClass
{
    public function __construct(string $message = "", int $code = 0, Throwable|null $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
