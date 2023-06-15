<?php
namespace PH7\ApiSimpleMenu;

use PH7\ApiSimpleMenu\Service\User;
use PH7\ApiSimpleMenu\Validation\Exception\InvalidValidationException;

use PH7\JustHttp\StatusCode;
use PH7\PhpHttpResponseHeader\Http;

enum UserAction: string
{
    case CREATE = 'create';
    case RETRIEVE_ALL = 'retrieveall';
    case RETRIEVE = 'retrieve';
    case REMOVE = 'remove';
    case UPDATE = 'update';

    public function getResponse(): string
    {
        $postBody = file_get_contents('php://input');
        $postBody = json_decode($postBody);

        // Ternary conditional operator operator
        $userId = $_REQUEST['id'] ?? null; // using the null coalescing operator

        $user = new User();
        try {
            $response = match ($this) {
                self::CREATE => $user->create($postBody),
                self::RETRIEVE_ALL => $user->retrieveAll(),
                self::RETRIEVE => $user->retrieve($userId),
                self::REMOVE => $user->remove($postBody),
                self::UPDATE => $user->update($postBody),
            };
        } catch (InvalidValidationException $e) {
            // Send 400 http status code
            Http::setHeadersByCode(StatusCode::BAD_REQUEST);

            $response = [
                'errors' => [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode()
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
