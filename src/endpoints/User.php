<?php
namespace PH7\ApiSimpleMenu;

use PH7\ApiSimpleMenu\Exception\InvalidValidationException;
use Respect\Validation\Validator as v;

class User
{
    public readonly int $userId;

    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $phone
    ) {
    }

    // public function create(object $data): self // <- can still be valid
    public function create(mixed $data): object
    {
        // storing the min/max lengths for first/last names
        $minimumLength = 2;
        $maximumLength = 60;

        // validation schema
        $schemaValidation = v::attribute('first', v::stringType()->length($minimumLength, $maximumLength))
            ->attribute('last', v::stringType()->length($minimumLength, $maximumLength))
            ->attribute('email', v::email(), mandatory: false)
            ->attribute('phone', v::phone(), mandatory: false);

        if ($schemaValidation->validate($data)) {
            return $data; // return statement exists the function and doesn't go beyond this scope
        }

        throw new InvalidValidationException("Invalid Data");
    }

    public function retrieveAll(): array
    {
        return [];
    }

    public function retrieve(string $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function update(mixed $postBody): self
    {
        // TODO Update `$postBody` to the DAL later on (for updating the database)

        return $this;
    }

    public function remove(string $userId): bool
    {
        // TODO Lookup the the DB user row with this userId

        return true; // default value
    }
}
