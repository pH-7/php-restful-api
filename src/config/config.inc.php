<?php
/**
 * @author     Pierre-Henry Soria <hi@ph7.me>
 * @website    https://ph7.me
 * @license    MIT License
 */

namespace PH7\ApiSimpleMenu;

use Dotenv\Dotenv;

enum Environment : string
{
    case DEVELOPMENT = 'development';
    case PRODUCTION = 'production';

    public function environmentName(): string
    {
         return match($this) {
            self::DEVELOPMENT => 'development',
            self::PRODUCTION => 'production'
        };
    }
}

$path = dirname(__DIR__, 2);
$dotenv = Dotenv::createImmutable($path);
$dotenv->load();

// optional: check if the necessary values are in the .env file
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS']);
