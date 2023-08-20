<?php
/**
 * @author     Pierre-Henry Soria <hi@ph7.me>
 * @website    https://ph7.me
 * @license    MIT License
 */

declare(strict_types=1);

namespace PH7\ApiSimpleMenu\Service;

use PH7\ApiSimpleMenu\Dal\TokenKeyDal;

class SecretKey
{
    public static function getJwtSecretKey(): string
    {
        $jwtKey = TokenKeyDal::getSecretKey();

        if (!$jwtKey) {
            $uniqueSecretKey = hash('sha512', strval(time()));
            TokenKeyDal::saveSecretKey($uniqueSecretKey);

            return $uniqueSecretKey;
        }

        return $jwtKey;
    }
}
