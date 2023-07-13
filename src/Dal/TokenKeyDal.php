<?php

namespace PH7\ApiSimpleMenu\Dal;

use RedBeanPHP\R;

final class TokenKeyDal
{
    public const TABLE_NAME = 'secretkeys';

    public static function saveSecretKey(string $jwtKey): void
    {
        $tokenBean = R::dispense(self::TABLE_NAME);
        $tokenBean->secretKey = $jwtKey;

        R::store($tokenBean);

        // close connection with database
        R::close();
    }

    public static function getSecretKey(): ?string
    {
        $tokenKeyBean = R::load(self::TABLE_NAME, 1);

        return $tokenKeyBean?->secretKey;
    }
}