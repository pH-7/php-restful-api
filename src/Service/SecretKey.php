<?php

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