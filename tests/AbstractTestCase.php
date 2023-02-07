<?php

namespace Itrn0\Iqtek\Dialer\Api\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Itrn0\Iqtek\Dialer\Api\Client;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    protected function createClient($stack): Client
    {
        $handlerStack = HandlerStack::create(new MockHandler($stack));
        return new Client([
            'base_uri' => 'http://localhost',
            'guzzle_options' => [
                'handler' => $handlerStack,
            ],
        ]);
    }

    protected function createJsonSuccessData($data): string
    {
        return json_encode([
            'success' => true,
            'data' => $data,
        ], JSON_THROW_ON_ERROR);
    }

    protected function createJsonFailData($data): string
    {
        return json_encode([
            'success' => false,
            'data' => $data,
        ], JSON_THROW_ON_ERROR);
    }
}