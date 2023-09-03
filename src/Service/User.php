<?php
/**
 * @author     Pierre-Henry Soria <hi@ph7.me>
 * @website    https://ph7.me
 * @license    MIT License
 */

declare(strict_types=1);

namespace PH7\ApiSimpleMenu\Service;

use Exception;
use Firebase\JWT\JWT;
use PH7\ApiSimpleMenu\Dal\UserDal;
use PH7\ApiSimpleMenu\Service\Exception\CannotLoginUserException;
use PH7\ApiSimpleMenu\Service\Exception\EmailExistsException;
use PH7\ApiSimpleMenu\Service\Exception\CredentialsInvalidException;
use PH7\ApiSimpleMenu\Validation\Exception\InvalidValidationException;
use PH7\ApiSimpleMenu\Validation\UserValidation;
use PH7\JustHttp\StatusCode;
use PH7\PhpHttpResponseHeader\Http as HttpResponse;
use Ramsey\Uuid\Uuid;
use Respect\Validation\Validator as v;
use PH7\ApiSimpleMenu\Entity\User as UserEntity;

class User
{
    public const DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    public function __construct(protected string $jwtSecretKey)
    {
    }

    public function login(mixed $data): array
    {
        $userValidation = new UserValidation($data);
        if ($userValidation->isLoginSchemaValid()) {
            if (UserDal::doesEmailExist($data->email)) {
                $user = UserDal::getByEmail($data->email);

                $areCredentialsValid = $user->getEmail() && password_verify($data->password, $user->getPassword());
                if ($areCredentialsValid) {
                    $userName = "{$user->getFirstName()} {$user->getLastName()}";

                    $currentTime = time();
                    $jwtToken = JWT::encode(
                        [
                            'iss' => $_ENV['APP_URL'],
                            'iat' => $currentTime,
                            'exp' => $currentTime + $_ENV['JWT_TOKEN_EXPIRATION'],
                            'data' => [
                                'email' => $data->email,
                                'name' => $userName
                            ]
                        ],
                        $this->jwtSecretKey,
                        $_ENV['JWT_ALGO_ENCRYPTION']
                    );

                    try {
                        UserDal::setToken($jwtToken, $user->getUserUuid());
                    } catch (Exception) { // since PHP 8.0, we can omit the caught variable name (e.g. Exception $e)
                        throw new CannotLoginUserException('Cannot set token to user');
                    }

                    return [
                        'message' => sprintf('%s successfully logged in', $userName),
                        'token' => $jwtToken
                    ];
                }
            }
            throw new CredentialsInvalidException('Credentials invalid');
        }
        throw new InvalidValidationException('Payload invalid');
    }

    public function create(mixed $data): array|object
    {
        $userValidation = new UserValidation($data);
        if ($userValidation->isCreationSchemaValid()) {
            $userUuid = Uuid::uuid4()->toString(); // assigning a UUID to the user

            $userEntity = new UserEntity();
            $userEntity
                ->setUserUuid($userUuid)
                ->setFirstName($data->first)
                ->setLastName($data->last)
                ->setEmail($data->email)
                ->setPhone($data->phone)
                ->setPassword(hashPassword($data->password))
                ->setCreationDate(date(self::DATE_TIME_FORMAT));

            $email = $userEntity->getEmail();
            if (UserDal::doesEmailExist($email)) {
                throw new EmailExistsException(
                    sprintf('Email address %s already exists', $email)
                );
            }

            if (!$userUuid = UserDal::create($userEntity)) {
                // If we receive an error while creating a user to the database, give a 400 to client
                HttpResponse::setHeadersByCode(StatusCode::BAD_REQUEST);

                // Set to empty result, because an issue happened. The client has to handle this properly
                $data = [];
            }

            // Send a 201 when the user has been successfully added to DB
            HttpResponse::setHeadersByCode(StatusCode::CREATED);

            // Add user UUID to the object to give back the user's UUID to the client
            $data->userUuid = $userUuid;

            return $data;
        }

        throw new InvalidValidationException("Invalid user payload");
    }

    public function update(mixed $postBody): array|object
    {
        $userValidation = new UserValidation($postBody);
        if ($userValidation->isUpdateSchemaValid()) {
            $userUuid = $postBody->userUuid;

            $userEntity = new UserEntity();
            if (!empty($postBody->first)) {
                $userEntity->setFirstName($postBody->first);
            }

            if (!empty($postBody->last)) {
                $userEntity->setLastName($postBody->last);
            }

            if (!empty($postBody->phone)) {
                $userEntity->setPhone($postBody->phone);
            }

            if (UserDal::update($userUuid, $userEntity) === false) {
                // Most likely, the user isn't found, set a 404 to the client
                HttpResponse::setHeadersByCode(StatusCode::NOT_FOUND);

                // If invalid or got an error, give back an empty response
                return [];
            }

            return $postBody;
        }

        throw new InvalidValidationException("Invalid user payload");
    }

    public function retrieveAll(): array
    {
        return UserDal::getAll();
    }

    public function retrieve(string $userUuid): array
    {
        if (v::uuid()->validate($userUuid)) {
            if ($user = UserDal::getById($userUuid)) {
                if ($user->getUserUuid()) {
                    // Retrieve the needed properties we want to expose for the user
                    return [
                        'userUuid' => $user->getUserUuid(),
                        'first' => $user->getFirstName(),
                        'last' => $user->getLastName(),
                        'email' => $user->getEmail(),
                        'phone' => $user->getPhone(),
                        'creationDate' => $user->getCreationDate()
                    ];
                }
            }

            return [];
        }

        throw new InvalidValidationException("Invalid user UUID");
    }

    /**
     * @internal Set `mixed` type, because if we get an incorrect payload with syntax errors, `json_decode` gives NULL,
     * and `object` wouldn't be a valid datatype here.
     */
    public function remove(mixed $data): bool
    {
        $userValidation = new UserValidation($data);
        if ($userValidation->isRemoveSchemaValid()) {
            // Send a 204 if the user got removed
            //HttpResponse::setHeadersByCode(StatusCode::NO_CONTENT);
            return UserDal::remove($data->userUuid);
        }

        throw new InvalidValidationException("Invalid user UUID");
    }
}
