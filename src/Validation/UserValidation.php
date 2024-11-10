<?php
/**
 * @author     Pierre-Henry Soria
 * @website    https://www.udemy.com/course/build-modern-php-api/
 * @website    https://ph7.me
 * @license    MIT License
 */

namespace PH7\ApiSimpleMenu\Validation;

use Respect\Validation\Validator as v;

class UserValidation
{
    /**
     * Storing min/max lengths for first/last names.
     *
     * @internal Since PHP 8.3, typed constant declarations are supported.
     *    If using PHP 8.3+, can be changed to: 
     *        private const int MINIMUM_NAME_LENGTH = 2;
     *        private const int MAXIMUM_NAME_LENGTH = 40;
     */
    private const MINIMUM_NAME_LENGTH = 2;
    private const MAXIMUM_NAME_LENGTH = 40;

    private const MINIMUM_PASSWORD_LENGTH = 5;

    public function __construct(private readonly mixed $data) {}

    public function isCreationSchemaValid(): bool
    {
        $schemaValidation =
            v::attribute('first', v::stringType()->length(self::MINIMUM_NAME_LENGTH, self::MAXIMUM_NAME_LENGTH))
            ->attribute('last', v::stringType()->length(self::MINIMUM_NAME_LENGTH, self::MAXIMUM_NAME_LENGTH))
            ->attribute('password', v::stringType()->length(self::MINIMUM_PASSWORD_LENGTH))
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

    public function isLoginSchemaValid(): bool
    {
        $schemaValidation =
            v::attribute('email', v::stringType())
            ->attribute('password', v::stringType());

        return $schemaValidation->validate($this->data);
    }
}
