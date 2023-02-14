<?php

namespace Itrn0\Iqtek\Dialer\Api;

use GuzzleHttp\Client as HttpClient;
use InvalidArgumentException;
use Itrn0\Iqtek\Dialer\Api\Entity\Bucket;
use Itrn0\Iqtek\Dialer\Api\Entity\Lead;
use Itrn0\Iqtek\Dialer\Api\Entity\Phone;
use Itrn0\Iqtek\Dialer\Api\Filter\ExternalIdFilter;
use Itrn0\Iqtek\Dialer\Api\Filter\IdFilter;
use JsonException;
use Throwable;

class Client
{
    private HttpClient $client;
    private ?string $apiKey;
    private array $options;

    public function __construct(array $options)
    {
        if (!isset($options['base_uri'])) {
            throw new InvalidArgumentException('base_uri is required');
        }
        $this->options = $options;
        $this->apiKey = $options['api_key'] ?? null;
        $this->initClient();
    }

    protected function initClient(): void
    {
        $this->client = new HttpClient(array_merge([
            'base_uri' => $this->options['base_uri'],
            'timeout' => $this->options['timeout'] ?? 30,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'X-API-KEY' => $this->apiKey ?? '',
            ],
        ], $this->options['guzzle_options'] ?? []));
    }

    /**
     * @throws ClientException
     */
    public function login(string $username, string $password): void
    {
        $data = $this->requestJson('POST', 'acl/users/api_key_login', [
            'login' => $username,
            'password' => $password,
        ]);
        $this->apiKey = $data;
        $this->initClient();
    }

    /**
     * @throws ClientException
     */
    private function requestJson($method, $path, $data = [])
    {
        return $this->request($method, $path, [
            'json' => $data,
        ]);
    }

    /**
     * @throws ClientException
     */
    private function request($method, $path, $options = [])
    {
        try {
            $response = $this->client->request($method, $path, $options);
            return $this->getData($response);
        } catch (Throwable $e) {
            if (strpos($e->getMessage(), 'Entity not found') !== false) {
                throw new EntityNotFoundException('Entity not found', 404, $e);
            }
            throw new ClientException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param $response
     * @param bool $returnError
     * @return mixed|null
     * @throws ClientException
     */
    private function getData($response, bool $returnError = false)
    {
        try {
            $data = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
            if ($returnError) {
                return $data;
            }
            if (($data['success'] ?? false) === false) {
                throw new ClientException($data['message'] ?? 'Unknown error');
            }
            return $data['data'] ?? null;
        } catch (JsonException $e) {
            throw new ClientException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param string|IdFilter|ExternalIdFilter $id
     * @return Lead
     * @throws ClientException
     */
    public function getLead($id): Lead
    {
        $data = $this->requestJson('POST', 'leads/get', $this->idToParams($id));
        return Lead::fromArray($data);
    }

    /**
     * @param Lead[] $leads
     * @param string|IdFilter|ExternalIdFilter $bucketId
     * @return void
     * @throws ClientException
     */
    public function addLeads(array $leads, $bucketId): void
    {
        $this->requestJson('POST', 'leads/bulk', [
            'bucket' => $this->idToParams($bucketId),
            'items' => array_map(static function (Lead $lead) {
                $params = [];
                if ($lead->getData()) {
                    $params['data'] = $lead->getData();
                }
                if ($lead->getNextTimeCall()) {
                    $params['next_time_call'] = $lead->getNextTimeCall();
                }
                if ($lead->getPhones()) {
                    $params['phones'] = array_map(static fn(Phone $phone) => $phone->toArray(), $lead->getPhones());
                }
                return array_merge([
                    'external_id' => $lead->getExternalId(),
                    'name' => $lead->getName(),
                    'priority' => $lead->getPriority(),
                    'active' => $lead->isActive(),
                    'timezone' => $lead->getTimezone(),
                ], $params);
            }, $leads),
        ]);
    }

    /**
     * @param string|IdFilter|ExternalIdFilter $id
     * @return Bucket
     * @throws ClientException
     */
    public function getBucket($id = null): Bucket
    {
        $data = $this->requestJson('GET', 'buckets/get', $this->idToParams($id));
        return Bucket::fromArray($data);
    }

    /**
     * Add bucket
     * @param Bucket $bucket
     * @return void
     * @throws ClientException
     */
    public function addBucket(Bucket $bucket): void
    {
        $params = [];
        if ($bucket->getSettings()) {
            $params['settings'] = $bucket->getSettings();
        }
        $data = $this->requestJson('POST', 'buckets', [
            'item' => array_merge([
                'external_id' => $bucket->getExternalId(),
                'name' => $bucket->getName(),
                'campaign_id' => $bucket->getCampaignId(),
                'active' => $bucket->isActive(),
                'priority' => $bucket->getPriority(),
                'description' => $bucket->getDescription(),
            ], $params),
        ]);
        $bucket->setId($data['id']);
    }

    private function idToParams($id): array
    {
        if ($id instanceof IdFilter) {
            return ['id' => $id->getValue()];
        }
        if ($id instanceof ExternalIdFilter) {
            return ['external_id' => $id->getValue()];
        }
        return ['id' => $id];
    }

    /**
     * Method to check if client is logged
     * @return bool
     */
    public function isLogged(): bool
    {
        return $this->apiKey !== null;
    }
}