<?php

namespace PH7\ApiSimpleMenu\Dal;


use Ramsey\Uuid\Uuid;
use RedBeanPHP\R;
class FoodItemDal
{
    public const TABLE_NAME = 'fooditems'; // Cannot have underscore. Use one word

    public static function get(string $itemUuid): ?array
    {
        $bindings = ['itemUuid' => $itemUuid];
        $itemBean = R::findOne(self::TABLE_NAME, 'item_uuid = :itemUuid', $bindings);

        return $itemBean?->export();
    }

    public static function getAll(): array
    {
        return R::findAll(self::TABLE_NAME);
    }

    public static function createDefaultItem(): int|string
    {
        $itemBan = R::dispense(self::TABLE_NAME);

        $itemBan->item_uuid = Uuid::uuid4()->toString();
        $itemBan->name = 'Burrito Chips';
        $itemBan->price = 19.55;
        $itemBan->available = true;

        // return the increment entry ID
        return R::store($itemBan);
    }
}