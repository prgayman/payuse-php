<?php

namespace Prgayman\PayUse\Exceptions;

use Exception;
use Throwable;

class PayUseException extends Exception
{
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        parent::__construct(strip_tags($message), $code, $previous);
    }
}
