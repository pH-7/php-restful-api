<?php
/**
 * @author     Pierre-Henry Soria <hi@ph7.me>
 * @website    https://ph7.me
 * @license    MIT License
 */

namespace PH7\ApiSimpleMenu\Route;

use PH7\ApiSimpleMenu\Route\Exception\NotFoundException;
use PH7\ApiSimpleMenu\Service\Exception\CannotLoginUserException;
use PH7\ApiSimpleMenu\Service\Exception\EmailExistsException;
use PH7\ApiSimpleMenu\Service\SecretKey;
use PH7\ApiSimpleMenu\Service\User;

use PH7\JustHttp\StatusCode;
use PH7\PhpHttpResponseHeader\Http as HttpResponse;

enum UserAction: string
{
    case LOGIN = 'login';
    case CREATE = 'create';
    case RETRIEVE_ALL = 'retrieveall';
    case RETRIEVE = 'retrieve';
    case REMOVE = 'remove';
    case UPDATE = 'update';

    /**
     * @throws Exception\NotFoundException
     */
    public function getResponse(): string
    {
        $postBody = file_get_contents('php://input');
        $postBody = json_decode($postBody);

        // Ternary conditional operator operator
        $userId = $_REQUEST['id'] ?? ''; // using the null coalescing operator

        // retrieve JWT secret key, and pass it to User Service' constructor
        $jwtToken = SecretKey::getJwtSecretKey();
        $user = new User($jwtToken);

        try {
            // first, let's check if HTTP method for the requested endpoint is valid
            $expectHttpMethod = match ($this) {
                self::LOGIN => Http::POST_METHOD,
                self::CREATE => Http::POST_METHOD,
                self::UPDATE => Http::PUT_METHOD,
                self::RETRIEVE_ALL => Http::GET_METHOD,
                self::RETRIEVE => Http::GET_METHOD,
                self::REMOVE => Http::DELETE_METHOD
            };

            if (Http::doesHttpMethodMatch($expectHttpMethod) === false) {
                throw new NotFoundException('HTTP method is incorrect. Request not found');
            }

            $response = match ($this) {
                self::LOGIN => $user->login($postBody),
                self::CREATE => $user->create($postBody),
                self::UPDATE => $user->update($postBody),
                self::RETRIEVE_ALL => $user->retrieveAll(),
                self::RETRIEVE => $user->retrieve($userId),
                self::REMOVE => $user->remove($postBody),
            };
        } catch (CannotLoginUserException $e) {
            // Send 400 http status code
            HttpResponse::setHeadersByCode(StatusCode::BAD_REQUEST);

            $response = [
                'errors' => [
                    'message' => $e->getMessage(),
                ]
            ];
        } catch (EmailExistsException $e) {
            HttpResponse::setHeadersByCode(StatusCode::BAD_REQUEST);

            $response = [
                'errors' => [
                    'message' => $e->getMessage()
                ]
            ];
        }

        return json_encode($response);
    }
}

$action = $_REQUEST['action'] ?? null;

$userAction = UserAction::tryFrom($action);
if ($userAction) {
    echo $userAction->getResponse();
} else {
    require_once 'not-found.routes.php';
}
