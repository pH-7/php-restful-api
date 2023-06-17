<?php

namespace PH7\ApiSimpleMenu\Service;

use PH7\ApiSimpleMenu\Dal\FoodItemDal;
use PH7\ApiSimpleMenu\Validation\Exception\InvalidValidationException;
use Respect\Validation\Validator as v;

class FoodItem
{
    public function retrieve(string $itemUuid): array
    {
        if (v::uuid()->validate($itemUuid)) {
            if ($item = FoodItemDal::get($itemUuid)) {
                // Removing fields we don't want to expose
                unset($item['id']);

                return $item;
            }

            return [];
        }

        throw new InvalidValidationException("Invalid user UUID");
    }

    public function retrieveAll(): array
    {
        $items = FoodItemDal::getAll();

        if (count($items) === 0) {
            // if no items have been added yet, create the first one
            FoodItemDal::createDefaultItem();

            // then, get again all items
            // to retrieve the new one that just got added
            $items = FoodItemDal::getAll();
        }

        return array_map(function (object $item): object {
            // Remove unnecessary "id" field
            unset($item['id']);
            return $item;
        }, $items);
    }
}