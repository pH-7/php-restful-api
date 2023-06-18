<?php
namespace PH7\ApiSimpleMenu;

use Whoops\Run as WhoopsRun;
use Whoops\Handler\JsonResponseHandler as WhoopsJsonResponseHandler;

require __DIR__ . '/vendor/autoload.php';

// handle all exceptions and convert them into JSON format
$whoops = new WhoopsRun();
$whoops->pushHandler(new WhoopsJsonResponseHandler);
$whoops->register();


require __DIR__ . '/src/helpers/headers.inc.php';
require __DIR__ . '/src/helpers/misc.inc.php';
require __DIR__ . '/src/config/config.inc.php';
require __DIR__ . '/src/config/database.inc.php'; // TODO Could find sth cleaner
require __DIR__ . '/src/Route/routes.php';