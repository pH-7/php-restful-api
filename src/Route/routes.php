<?php
/**
 * @author     Pierre-Henry Soria <hi@ph7.me>
 * @website    https://ph7.me
 * @license    MIT License
 */

namespace PH7\ApiSimpleMenu\Route;

use PH7\ApiSimpleMenu\Route\Exception\NotFoundException;
use PH7\ApiSimpleMenu\Service\Exception\CredentialsInvalidException;
use PH7\ApiSimpleMenu\Validation\Exception\InvalidValidationException;
use PH7\JustHttp\StatusCode;
use PH7\PhpHttpResponseHeader\Http as HttpResponse;

$resource = $_REQUEST['resource'] ?? null;

try {
    return match ($resource) {
        'user' => require_once 'user.routes.php',
        'item' => require_once 'food-item.routes.php',
        default => require_once 'not-found.routes.php',
    };
} catch (CredentialsInvalidException $e) {
    response([
        'errors' => [
            'message' => $e->getMessage()
        ]
    ]);
} catch (InvalidValidationException $e) {
    // Send 400 http status code
    HttpResponse::setHeadersByCode(StatusCode::BAD_REQUEST);

    response([
        'errors' => [
            'message' => $e->getMessage(),
            'code' => $e->getCode()
        ]
    ]);
} catch (NotFoundException $e) {
    // FYI, not-found.Route already sends a 404 Not Found HTTP code
    return require_once 'not-found.routes.php';
}
