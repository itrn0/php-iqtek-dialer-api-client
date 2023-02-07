<?php

namespace Itrn0\Iqtek\Dialer\Api;

use Exception;
use Throwable;

class ClientException extends Exception
{
    public function __construct($message = 'Client exception', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}