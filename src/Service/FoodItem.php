<?php
/**
 * @author     Pierre-Henry Soria <hi@ph7.me>
 * @website    https://ph7.me
 * @license    MIT License
 */

declare(strict_types=1);

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
            $this->createDefaultItem();

            // then, get again all items
            // to retrieve the new one that just got added
            $items = FoodItemDal::getAll();
        }

        return $items;
    }

    private function createDefaultItem(): void
    {
        // default item values
        $defaultPrice = 19.99;
        $isEnabled = true;


        // if no items have been added yet, create the first one
        $itemUuid = Uuid::uuid4()->toString();
        $itemEntity = new ItemEntity();

        // chaining each method with the arrow ->
        $itemEntity
            ->setItemUuid($itemUuid)
            ->setName('Burrito Cheese with French Fries')
            ->setPrice($defaultPrice)
            ->setAvailable($isEnabled);

        FoodItemDal::insertDefaultItem($itemEntity);
    }
}
