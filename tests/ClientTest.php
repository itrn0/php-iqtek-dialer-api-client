<?php

namespace Itrn0\Iqtek\Dialer\Api\Tests;

use GuzzleHttp\Psr7\Response;
use Itrn0\Iqtek\Dialer\Api\ClientException;

class ClientTest extends AbstractTestCase
{

    public function testLoginFail(): void
    {
        $client = $this->createClient([
            new Response(200, [], $this->createJsonFailData('Invalid credentials')),
        ]);
        self::assertFalse($client->isLogged());
        $this->expectException(ClientException::class);
        $client->login('test', 'pass');
    }

    public function testLogin(): void
    {
        $client = $this->createClient([
            new Response(200, [], $this->createJsonSuccessData('API_KEY')),
        ]);
        self::assertFalse($client->isLogged());
        $client->login('test', 'pass');
        self::assertTrue($client->isLogged());
    }

    public function testGetLeadFail(): void
    {
        $id = '28f0c9c0-0b1a-11eb-9b8b-0242ac110002';
        $client = $this->createClient([
            new Response(200, [], $this->createJsonFailData('Lead not found')),
        ]);
        $this->expectException(ClientException::class);
        $client->getLead($id);
    }
    
    public function testGetLead(): void
    {
        $id = '28f0c9c0-0b1a-11eb-9b8b-0242ac110002';
        $client = $this->createClient([
            new Response(200, ['Content-Type' => 'application/json'], $this->createJsonSuccessData([
                'id' => $id,
                'external_id' => '09a0c9c0-0b1a-11eb-9b8b-0242ac110002',
                'name' => 'test',
                'active' => true,
                'data' => [],
                'status' => 'active',
                'campaign_id' => '48f0c9c0-0b1a-11eb-9b8b-0242ac110002',
                'bucket_id' => '58f0c9c0-0b1a-11eb-9b8b-0242ac110002',
                'attempts' => 0,
                'created_at' => '2020-10-12T12:00:00+00:00',
                'updated_at' => '2020-10-12T12:00:00+00:00',
                'priority' => 0,
            ])),
        ]);
        $lead = $client->getLead($id);
        self::assertNotNull($lead);
        self::assertEquals($id, $lead->getId());
    }
}
