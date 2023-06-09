<?php
namespace PH7\ApiSimpleMenu;

use PH7\ApiSimpleMenu\Validation\Exception\InvalidValidationException;
use PH7\ApiSimpleMenu\Validation\UserValidation;
use Ramsey\Uuid\Uuid;
use Respect\Validation\Validator as v;

class User
{
    public readonly ?string $userId;

    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $phone,
    ) {}

    // public function create(object $data): self // <- can still be valid
    public function create(mixed $data): object
    {
        // validate data
        $userValidation = new UserValidation($data);
        if ($userValidation->isCreationSchemaValid()) {
            $data->userId = Uuid::uuid4(); // assigning a UUID to the user

            return $data; // return statement exists the function and doesn't go beyond this scope
        }

        throw new InvalidValidationException("Invalid user payload");
    }

    public function retrieveAll(): array
    {
        return [];
    }

    public function retrieve(string $userId): self
    {
        if (v::uuid()->validate($userId)) {
            $this->userId = $userId;

            return $this;
        }

        throw new InvalidValidationException("Invalid user UUID");
    }

    public function update(mixed $postBody): object
    {
        // validation schema
        $userValidation = new UserValidation($postBody);
        if ($userValidation->isUpdateSchemaValid()) {
            return $postBody;
        }

        throw new InvalidValidationException("Invalid user payload");
    }

    public function remove(string $userId): bool
    {
        if (v::uuid()->validate($userId)) {
            $this->userId = $userId;
        } else {
            throw new InvalidValidationException("Invalid user UUID");
        }


        // TODO Lookup the the DB user row with this userId
        return true; // default value
    }
}
