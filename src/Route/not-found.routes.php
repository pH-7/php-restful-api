<?php
namespace PH7\ApiSimpleMenu\Route;

use PH7\JustHttp\StatusCode;
use PH7\PhpHttpResponseHeader\Http;

$getResponse = fn(): string => json_encode(['error' => 'Request not found']);

// Send HTTP 404 Not Found
Http::setHeadersByCode(StatusCode::NOT_FOUND);
echo $getResponse();