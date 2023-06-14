<?php
namespace PH7\ApiSimpleMenu;

$resource = $_REQUEST['resource'] ?? null;

return match ($resource) {
    'user' => require_once 'user.routes.php',
    default => require_once 'not-found.routes.php',
};
