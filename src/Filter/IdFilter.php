<?php

namespace Itrn0\Iqtek\Dialer\Api\Filter;

class IdFilter implements Filter
{
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getValue(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}