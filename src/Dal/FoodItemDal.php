<?php
/**
 * @author     Pierre-Henry Soria <hi@ph7.me>
 * @website    https://ph7.me
 * @license    MIT License
 */

declare(strict_types=1);

namespace PH7\ApiSimpleMenu\Dal;

use PH7\ApiSimpleMenu\Entity\Item as ItemEntity;
use RedBeanPHP\R;

final class FoodItemDal
{
    public const TABLE_NAME = 'fooditems'; // Cannot have underscore. Use one word

    public static function get(string $itemUuid): ItemEntity
    {
        $bindings = ['itemUuid' => $itemUuid];
        $itemBean = R::findOne(self::TABLE_NAME, 'item_uuid = :itemUuid', $bindings);

        return (new ItemEntity())->unserialize($itemBean?->export());
    }

    public static function getAll(): array
    {
        $itemsBean = R::findAll(self::TABLE_NAME);

        $areAnyItems = $itemsBean && count($itemsBean);

        if (!$areAnyItems) {
            // if no items found, return empty array
            return [];
        }

        return array_map(
            function (object $itemBean): array {
                $itemEntity = (new ItemEntity())->unserialize($itemBean?->export());

                // Select the fields we want to export and give back to the client
                return [
                    'foodUuid' => $itemEntity->getItemUuid(),
                    'name' => $itemEntity->getName(),
                    'price' => $itemEntity->getPrice(),
                    'available' => $itemEntity->getAvailable()
                ];
            }, $itemsBean);
    }

    public static function insertDefaultItem(ItemEntity $itemEntity): int|string
    {
        $itemBan = R::dispense(self::TABLE_NAME);

        $itemBan->item_uuid = $itemEntity->getItemUuid();
        $itemBan->name = $itemEntity->getName();
        $itemBan->price = $itemEntity->getPrice();
        $itemBan->available = $itemEntity->getAvailable();

        // return the increment entry ID
        return R::store($itemBan);
    }
}
