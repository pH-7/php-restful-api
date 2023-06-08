<?php
namespace PH7\ApiSimpleMenu;

use Exception;
use PH7\ApiSimpleMenu\Exception\InvalidValidationException;

require_once dirname(__DIR__) . '/endpoints/User.php';

// PHP 8.1 enums
enum UserAction: string
{
    case CREATE = 'create';
    case RETRIEVE_ALL = 'retrieveAll';
    case RETRIEVE = 'retrieve';
    case REMOVE = 'remove';
    case UPDATE = 'update';

    public function getResponse(): string
    {
        $postBody = file_get_contents('php://input');
        $postBody = json_decode($postBody);

        // Ternary conditional operator operator
        $userId = !empty($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

        // TODO Remove the hard-coded values from here
        $user = new User('Pierre', 'pierre@soria.email', '042634759375');

        try {
            $response = match ($this) {
                self::CREATE => $user->create($postBody),
                self::RETRIEVE_ALL => $user->retrieveAll(),
                self::RETRIEVE => $user->retrieve($userId),
                self::REMOVE => $user->remove($userId),
                self::UPDATE => $user->update($postBody),
            };
        } catch (InvalidValidationException | Exception $e) {
            // TODO Send 400 status code with header()
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


$action = $_GET['action'] ?? null;

// PHP 8.0 match - https://stitcher.io/blog/php-8-match-or-switch
// Various HTTP codes explained here: https://www.apiscience.com/blog/7-ways-to-validate-that-your-apis-are-working-correctly/
$userAction = match ($action) {
    'create' => UserAction::CREATE, // send 201
    'retrieve' => UserAction::RETRIEVE, // send 200
    'remove' => UserAction::REMOVE, // send 204 status code
    'update' => UserAction::UPDATE, //
    default => UserAction::RETRIEVE_ALL, // send 200
};


// response, as described in https://jsonapi.org/format/#profile-rules
echo $userAction->getResponse();
