<?php
/**
 * @author     Pierre-Henry Soria <hi@ph7.me>
 * @website    https://ph7.me
 * @license    MIT License
 */

declare(strict_types=1);

namespace PH7\ApiSimpleMenu;

class AllowCors
{
    private const ALLOW_CORS_ORIGIN_KEY = 'Access-Control-Allow-Origin';
    private const ALLOW_CORS_METHOD_KEY = 'Access-Control-Allow-Methods';

    private const ALLOW_CORS_ORIGIN_VALUE = '*';
    private const ALLOW_CORS_METHODS_VALUE = 'GET, POST, PUT, DELETE, PATCH, OPTIONS';

    /**
     * Initialize the Cross-Origin Resource Sharing (CORS) headers.
     */
    public function init(): void
    {
        $this->set(self::ALLOW_CORS_ORIGIN_KEY, self::ALLOW_CORS_ORIGIN_VALUE);
        $this->set(self::ALLOW_CORS_METHOD_KEY, self::ALLOW_CORS_METHODS_VALUE);
    }

    private function set(string $key, string $value): void
    {
        header($key . ':' . $value);
    }
}
