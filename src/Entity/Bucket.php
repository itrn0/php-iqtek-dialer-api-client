<?php

namespace Itrn0\Iqtek\Dialer\Api\Entity;

class Bucket
{
    private string $id;
    private string $externalId;
    private string $campaignId;
    private bool $active = false;
    private int $priority = 0;
    private string $name;
    private string $description = '';
    private array $settings = [];

    public function __construct(string $id, string $campaignId, string $name)
    {
        $this->id = $id;
        $this->campaignId = $campaignId;
        $this->name = $name;
    }

    public static function fromArray(array $data): Bucket
    {
        $bucket = new self($data['id'], $data['campaign_id'], $data['name']);
        $bucket->setExternalId($data['external_id']);
        $bucket->setActive((bool)$data['active']);
        $bucket->setPriority($data['priority']);
        $bucket->setDescription($data['description']);
        $bucket->setSettings($data['settings'] ?? []);
        return $bucket;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'external_id' => $this->getExternalId(),
            'campaign_id' => $this->getCampaignId(),
            'active' => $this->isActive(),
            'priority' => $this->getPriority(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'settings' => $this->getSettings(),
        ];
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
     * @return Bucket
     */
    public function setId(string $id): Bucket
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
     * @return Bucket
     */
    public function setExternalId(string $externalId): Bucket
    {
        $this->externalId = $externalId;
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
     * @return Bucket
     */
    public function setCampaignId(string $campaignId): Bucket
    {
        $this->campaignId = $campaignId;
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
     * @return Bucket
     */
    public function setActive(bool $active): Bucket
    {
        $this->active = $active;
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
     * @return Bucket
     */
    public function setPriority(int $priority): Bucket
    {
        $this->priority = $priority;
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
     * @return Bucket
     */
    public function setName(string $name): Bucket
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Bucket
     */
    public function setDescription(string $description): Bucket
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return array
     */
    public function getSettings(): array
    {
        return $this->settings;
    }

    /**
     * @param array $settings
     * @return Bucket
     */
    public function setSettings(array $settings): Bucket
    {
        $this->settings = $settings;
        return $this;
    }
}