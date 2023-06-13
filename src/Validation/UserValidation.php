<?php

namespace PH7\ApiSimpleMenu\Validation;

use Respect\Validation\Validator as v;

class UserValidation
{
    // storing the min/max lengths for first/last names
    private const MINIMUM_NAME_LENGTH = 2;
    private const MAXIMUM_NAME_LENGTH = 40;

    public function __construct(private readonly mixed $data) {}

    public function isCreationSchemaValid(): bool
    {
        $schemaValidation =
            v::attribute('first', v::stringType()->length(self::MINIMUM_NAME_LENGTH, self::MAXIMUM_NAME_LENGTH))
            ->attribute('last', v::stringType()->length(self::MINIMUM_NAME_LENGTH, self::MAXIMUM_NAME_LENGTH))
            ->attribute('email', v::email())
            ->attribute('phone', v::phone());

        return $schemaValidation->validate($this->data);
    }

    public function isRemoveSchemaValid(): bool
    {
        return v::attribute('userUuid', v::uuid())->validate($this->data);
    }

    public function isUpdateSchemaValid(): bool
    {
        $schemaValidation =
            v::attribute('userUuid', v::uuid())
            ->attribute('first', v::stringType()->length(self::MINIMUM_NAME_LENGTH, self::MAXIMUM_NAME_LENGTH), mandatory: false)
            ->attribute('last', v::stringType()->length(self::MINIMUM_NAME_LENGTH, self::MAXIMUM_NAME_LENGTH), mandatory: false)
            ->attribute('phone', v::phone(), mandatory: false);

        return $schemaValidation->validate($this->data);
    }
}