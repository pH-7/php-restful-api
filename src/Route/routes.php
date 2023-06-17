<?php
namespace PH7\ApiSimpleMenu\Route;

use PH7\ApiSimpleMenu\Route\Exception\NotFoundException;

$resource = $_REQUEST['resource'] ?? null;

try {
    return match ($resource) {
        'user' => require_once 'user.routes.php',
        'item' => require_once 'food-item.routes.php',
        default => require_once 'not-found.routes.php',
    };
} catch (NotFoundException $e) {
    // FYI, not-found.Route already sends a 404 Not Found HTTP code
    return require_once 'not-found.routes.php';
}
