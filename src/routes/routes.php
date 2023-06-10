<?php
namespace PH7\ApiSimpleMenu;

$resource = $_REQUEST['resource'] ?? null;

switch ($resource) {
    case 'user':
        return require_once 'user.routes.php';

    default:
        return require_once 'main.routes.php';
}