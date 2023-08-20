<?php
/**
 * @author     Pierre-Henry Soria <hi@ph7.me>
 * @website    https://ph7.me
 * @license    MIT License
 */

namespace PH7\ApiSimpleMenu;

use PH7\PhpHttpResponseHeader\Http;

(new AllowCors)->init();

Http::setContentType('application/json');
