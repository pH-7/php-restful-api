<?php
/**
 * @author     Pierre-Henry Soria <hi@ph7.me>
 * @website    https://ph7.me
 * @license    MIT License
 */

namespace PH7\ApiSimpleMenu\Route;

use PH7\JustHttp\StatusCode;
use PH7\PhpHttpResponseHeader\Http;

// PHP 7.4 anonymous arrow function
$getResponse = fn(): string => json_encode(['error' => 'Request not found']);

// Send HTTP 404 Not Found
Http::setHeadersByCode(StatusCode::NOT_FOUND);
echo $getResponse();
