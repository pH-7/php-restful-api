<?php

namespace PH7\ApiSimpleMenu\Entity;

class Item implements Entitable
{
    private int $sequentialId;

    private ?string $itemUuid = null;

    private string $name;

    private float $price;

    private bool $available;

    public function setSequentialId(int $sequentialId): void
    {
        $this->sequentialId = $sequentialId;
    }

    public function getSequentialId(): int
    {
        return $this->sequentialId;
    }

    public function setItemUuid(string $itemUuid): void
    {
        $this->itemUuid = $itemUuid;
    }

    public function getItemUuid(): ?string
    {
        return $this->itemUuid;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setAvailable(bool $available): void
    {
        $this->available = $available;
    }

    public function getAvailable(): bool
    {
        return $this->available;
    }

    public function unserialize(?array $data): self
    {
        if (!empty($data['id'])) {
            $this->setSequentialId($data['id']);
        }

        if (!empty($data['item_uuid'])) {
            $this->setItemUuid($data['item_uuid']);
        }

        if (!empty($data['name'])) {
            $this->setName($data['name']);
        }

        if (!empty($data['price'])) {
            $this->setPrice($data['price']);
        }

        if (!empty($data['available'])) {
            $this->setAvailable($data['available']);
        }

        return $this;
    }
}