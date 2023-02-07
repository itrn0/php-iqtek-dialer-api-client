<?php

namespace Itrn0\Iqtek\Dialer\Api\Entity;

use DateTimeImmutable;
use DateTimeInterface;

class Lead
{
    private string $id;
    private string $externalId;
    private string $name;
    private bool $active;
    private array $data;
    private string $status;
    private string $campaignId;
    private string $bucketId;
    private int $attempts;
    private DateTimeInterface $createdAt;
    private DateTimeInterface $updatedAt;
    private ?string $nextTimeCall = null;
    private int $priority;

    public function __construct(string $id, string $campaignId, string $bucketId, string $name)
    {
        $this->id = $id;
        $this->campaignId = $campaignId;
        $this->bucketId = $bucketId;
        $this->name = $name;
    }

    public static function fromArray(array $data): Lead
    {
        $lead = new self($data['id'], $data['campaign_id'], $data['bucket_id'], $data['name']);
        $lead->setActive((bool)$data['active']);
        $lead->setData($data['data']);
        $lead->setStatus($data['status']);
        $lead->setExternalId($data['external_id']);
        $lead->setAttempts((int)$data['attempts']);
        $lead->setCreatedAt(new DateTimeImmutable($data['created_at']));
        $lead->setUpdatedAt(new DateTimeImmutable($data['updated_at']));
        $lead->setNextTimeCall($data['next_time_call'] ?? null);
        $lead->setPriority($data['priority']);
        return $lead;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Lead
     */
    public function setId(string $id): Lead
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getExternalId(): string
    {
        return $this->externalId;
    }

    /**
     * @param string $externalId
     * @return Lead
     */
    public function setExternalId(string $externalId): Lead
    {
        $this->externalId = $externalId;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Lead
     */
    public function setName(string $name): Lead
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return Lead
     */
    public function setActive(bool $active): Lead
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return Lead
     */
    public function setData(array $data): Lead
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Lead
     */
    public function setStatus(string $status): Lead
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getCampaignId(): string
    {
        return $this->campaignId;
    }

    /**
     * @param string $campaignId
     * @return Lead
     */
    public function setCampaignId(string $campaignId): Lead
    {
        $this->campaignId = $campaignId;
        return $this;
    }

    /**
     * @return string
     */
    public function getBucketId(): string
    {
        return $this->bucketId;
    }

    /**
     * @param string $bucketId
     * @return Lead
     */
    public function setBucketId(string $bucketId): Lead
    {
        $this->bucketId = $bucketId;
        return $this;
    }

    /**
     * @return int
     */
    public function getAttempts(): int
    {
        return $this->attempts;
    }

    /**
     * @param int $attempts
     * @return Lead
     */
    public function setAttempts(int $attempts): Lead
    {
        $this->attempts = $attempts;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     * @return Lead
     */
    public function setCreatedAt(DateTimeInterface $createdAt): Lead
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeInterface $updatedAt
     * @return Lead
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt): Lead
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getNextTimeCall(): string
    {
        return $this->nextTimeCall;
    }

    /**
     * @param string|null $nextTimeCall
     * @return Lead
     */
    public function setNextTimeCall(?string $nextTimeCall): Lead
    {
        $this->nextTimeCall = $nextTimeCall;
        return $this;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     * @return Lead
     */
    public function setPriority(int $priority): Lead
    {
        $this->priority = $priority;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'external_id' => $this->getExternalId(),
            'name' => $this->getName(),
            'active' => $this->isActive(),
            'data' => $this->getData(),
            'status' => $this->getStatus(),
            'campaign_id' => $this->getCampaignId(),
            'bucket_id' => $this->getBucketId(),
            'attempts' => $this->getAttempts(),
            'created_at' => $this->getCreatedAt()->format('c'),
            'updated_at' => $this->getUpdatedAt()->format('c'),
            'next_time_call' => $this->getNextTimeCall(),
            'priority' => $this->getPriority(),
        ];
    }


}