<?php

namespace Itrn0\Iqtek\Dialer\Api\Entity;

class Phone
{
    private ?string $externalId = null;
    private string $phone;
    private ?string $type = null;
    private int $priority = 0;
    private bool $active = false;

    public function __construct(string $phone)
    {
        $this->phone = $phone;
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
     * @return Phone
     */
    public function setExternalId(?string $externalId): Phone
    {
        $this->externalId = $externalId;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return Phone
     */
    public function setPhone(string $phone): Phone
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return Phone
     */
    public function setType(?string $type): Phone
    {
        $this->type = $type;
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
     * @return Phone
     */
    public function setPriority(int $priority): Phone
    {
        $this->priority = $priority;
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
     * @return Phone
     */
    public function setActive(bool $active): Phone
    {
        $this->active = $active;
        return $this;
    }

    public static function fromArray(array $data): Phone
    {
        $phone = new self($data['phone']);
        $phone->setExternalId($data['external_id'] ?? null);
        $phone->setType($data['type'] ?? null);
        $phone->setPriority($data['priority'] ?? 0);
        $phone->setActive((bool)$data['active']);
        return $phone;
    }

    public function toArray(): array
    {
        return [
            'external_id' => $this->getExternalId(),
            'phone' => $this->getPhone(),
            'type' => $this->getType(),
            'priority' => $this->getPriority(),
            'active' => $this->isActive(),
        ];
    }
}