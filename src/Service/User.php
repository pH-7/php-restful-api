<?php
namespace PH7\ApiSimpleMenu\Service;

use PH7\ApiSimpleMenu\Dal\UserDal;
use PH7\ApiSimpleMenu\Validation\Exception\InvalidValidationException;
use PH7\ApiSimpleMenu\Validation\UserValidation;
use PH7\JustHttp\StatusCode;
use PH7\PhpHttpResponseHeader\Http;
use Ramsey\Uuid\Uuid;
use RedBeanPHP\RedException\SQL;
use Respect\Validation\Validator as v;
use PH7\ApiSimpleMenu\Entity\User as UserEntity;

class User
{
    public const DATE_TIME_FORMAT = 'Y-m-d H:i:s';

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
            $userUuid = Uuid::uuid4(); // assigning a UUID to the user

            $userEntity = new UserEntity();
            $userEntity
                ->setUserUuid($userUuid)
                ->setFirstName($data->first)
                ->setLastName($data->last)
                ->setEmail($data->email)
                ->setPhone($data->phone)
                ->setCreationDate(date(self::DATE_TIME_FORMAT));

            try {
                UserDal::create($userEntity);
            } catch (SQL $exception) {
                // Set an internal error when we cannot add an entry to the database
                Http::setHeadersByCode(StatusCode::INTERNAL_SERVER_ERROR);

                // Set to empty result, because an issue happened. The client has to handle this properly
                $data = [];
            }

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
            // TODO To be implemented

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
            // TODO To be implemented
        } else {
            throw new InvalidValidationException("Invalid user UUID");
        }


        // TODO Lookup the the DB user row with this userId
        return true; // default value
    }
}
