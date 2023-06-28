<?php

namespace PH7\ApiSimpleMenu\Service;

use PH7\ApiSimpleMenu\Dal\FoodItemDal;
use PH7\ApiSimpleMenu\Entity\Item as ItemEntity;
use PH7\ApiSimpleMenu\Validation\Exception\InvalidValidationException;
use Ramsey\Uuid\Uuid;
use Respect\Validation\Validator as v;

class FoodItem
{
    public function retrieve(string $itemUuid): array
    {
        if (v::uuid()->validate($itemUuid)) {
            if ($item = FoodItemDal::get($itemUuid)) {
                if ($item->getItemUuid()) {
                   return [
                       'itemUuid' => $item->getItemUuid(),
                       'name' => $item->getName(),
                       'price' => $item->getPrice(),
                       'available' => $item->getAvailable()
                   ];
                }
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
            $itemUuid = Uuid::uuid4()->toString();
            $itemEntity = new ItemEntity();

            // chaining each method with the arrow ->
            $itemEntity
                ->setItemUuid($itemUuid)
                ->setName('Burrito Cheese with French Fries')
                ->setPrice(19.99)
                ->setAvailable(true);

            FoodItemDal::createDefaultItem($itemEntity);

            // then, get again all items
            // to retrieve the new one that just got added
            $items = FoodItemDal::getAll();
        }

        return $items;
    }
}