<?php

namespace Itrn0\Iqtek\Dialer\Api\Entity;

use DateTimeImmutable;
use DateTimeInterface;

class Lead
{
    private ?string $id = null;
    private ?string $externalId = null;
    private string $name;
    private bool $active;
    private array $data = [];
    private string $status = '';
    private ?string $campaignId = null;
    private ?string $bucketId = null;
    private int $attempts = 0;
    private ?DateTimeInterface $createdAt = null;
    private ?DateTimeInterface $updatedAt = null;
    private ?string $nextTimeCall = null;
    private int $priority = 0;
    private array $phones;
    private int $timezone = 0;

    public function __construct(string $name, array $phones = [], bool $active = false)
    {
        $this->name = $name;
        $this->phones = $phones;
        $this->active = $active;
    }

    public static function fromArray(array $data): Lead
    {
        $lead = new self($data['name']);
        $lead->setId($data['id'] ?? null);
        $lead->setBucketId($data['bucket_id'] ?? null);
        $lead->setCampaignId($data['campaign_id'] ?? null);
        $lead->setActive((bool)$data['active']);
        $lead->setData($data['data'] ?? []);
        $lead->setStatus($data['status'] ?? '');
        $lead->setExternalId($data['external_id'] ?? null);
        $lead->setAttempts((int)$data['attempts']);
        $lead->setCreatedAt(isset($data['created_at']) ? new DateTimeImmutable($data['created_at']) : null);
        $lead->setUpdatedAt(isset($data['updated_at']) ? new DateTimeImmutable($data['updated_at']) : null);
        $lead->setNextTimeCall($data['next_time_call'] ?? null);
        $lead->setPriority($data['priority'] ?? 0);
        $lead->setTimezone($data['timezone'] ?? 0);
        if (isset($data['phones']) && is_array($data['phones'])) {
            $lead->setPhones(array_map(static fn(array $phone) => Phone::fromArray($phone), $data['phones']));
        }
        return $lead;
    }

    /**
     * @return Phone[]
     */
    public function getPhones(): array
    {
        return $this->phones;
    }

    /**
     * @param Phone[] $phones
     * @return Lead
     */
    public function setPhones(array $phones): Lead
    {
        $this->phones = $phones;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return Lead
     */
    public function setId(?string $id): Lead
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    /**
     * @param string|null $externalId
     * @return Lead
     */
    public function setExternalId(?string $externalId): Lead
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
     * @return string|null
     */
    public function getCampaignId(): ?string
    {
        return $this->campaignId;
    }

    /**
     * @param string|null $campaignId
     * @return Lead
     */
    public function setCampaignId(?string $campaignId): Lead
    {
        $this->campaignId = $campaignId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBucketId(): ?string
    {
        return $this->bucketId;
    }

    /**
     * @param string|null $bucketId
     * @return Lead
     */
    public function setBucketId(?string $bucketId): Lead
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
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface|null $createdAt
     * @return Lead
     */
    public function setCreatedAt(?DateTimeInterface $createdAt): Lead
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeInterface|null $updatedAt
     * @return Lead
     */
    public function setUpdatedAt(?DateTimeInterface $updatedAt): Lead
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNextTimeCall(): ?string
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

    /**
     * @return int
     */
    public function getTimezone(): int
    {
        return $this->timezone;
    }

    /**
     * @param int $timezone
     * @return Lead
     */
    public function setTimezone(int $timezone): Lead
    {
        $this->timezone = $timezone;
        return $this;
    }

}