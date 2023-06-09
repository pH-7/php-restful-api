<?php
namespace PH7\ApiSimpleMenu;

use PH7\PhpHttpResponseHeader\Http;

(new AllowCors)->init();

Http::setContentType('application/json');