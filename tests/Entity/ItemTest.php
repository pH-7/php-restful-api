<?php

declare(strict_types=1);

namespace PH7\ApiSimpleMenu\Tests\Entity;

use PH7\ApiSimpleMenu\Entity\Item as ItemEntity;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class ItemTest extends TestCase
{
    private ItemEntity $itemEntity;

    protected function setUp(): void
    {
        $this->itemEntity = new ItemEntity();
    }

    public function testSequentialId(): void
    {
        $expectedValue = 1;

        $this->itemEntity->setSequentialId($expectedValue);

        $this->assertSame($expectedValue, $this->itemEntity->getSequentialId());
    }

    public function testUnserialize(): void
    {
        $uuid = Uuid::uuid4()->toString();

        $expectedItemData = [
            'id' => 500,
            'item_uuid' => $uuid,
            'name' => 'Société® Roquefort',
            'price' => 22.00,
            'available' => true
        ];

        $this->itemEntity->unserialize($expectedItemData);

        $this->assertSame($expectedItemData['id'], $this->itemEntity->getSequentialId());
        $this->assertSame($expectedItemData['item_uuid'], $this->itemEntity->getItemUuid());
        $this->assertSame($expectedItemData['name'], $this->itemEntity->getName());
        $this->assertSame($expectedItemData['price'], $this->itemEntity->getPrice());
        $this->assertTrue($expectedItemData['available']);
    }
}