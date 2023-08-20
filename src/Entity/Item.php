<?php
/**
 * @author     Pierre-Henry Soria <hi@ph7.me>
 * @website    https://ph7.me
 * @license    MIT License
 */

declare(strict_types=1);

namespace PH7\ApiSimpleMenu\Entity;

class Item implements Entitable
{
    private int $sequentialId;

    private ?string $itemUuid = null;

    private string $name;

    private float $price;

    private bool $available;

    public function setSequentialId(int $sequentialId): self
    {
        $this->sequentialId = $sequentialId;

        return $this;
    }

    public function getSequentialId(): int
    {
        return $this->sequentialId;
    }

    public function setItemUuid(string $itemUuid): self
    {
        $this->itemUuid = $itemUuid;

        return $this;
    }

    public function getItemUuid(): ?string
    {
        return $this->itemUuid;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setAvailable(bool $available): self
    {
        $this->available = $available;

        return $this;
    }

    public function getAvailable(): bool
    {
        return $this->available;
    }

    public function unserialize(?array $data): self
    {
        if (!empty($data['id'])) {
            $sequentialId = (int)$data['id'];
            $this->setSequentialId($sequentialId);
        }

        if (!empty($data['item_uuid'])) {
            $this->setItemUuid($data['item_uuid']);
        }

        if (!empty($data['name'])) {
            $this->setName($data['name']);
        }

        if (!empty($data['price'])) {
            $price = (float)$data['price'];
            $this->setPrice($price);
        }

        if (!empty($data['available'])) {
            $isAvailable = (bool)$data['available'];
            $this->setAvailable($isAvailable);
        }

        return $this;
    }
}
