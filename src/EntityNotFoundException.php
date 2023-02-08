<?php

namespace Itrn0\Iqtek\Dialer\Api;

use Throwable;

class EntityNotFoundException extends ClientException
{
    public function __construct($message = 'Entity not found', $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}