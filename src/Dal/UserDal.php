<?php

namespace PH7\ApiSimpleMenu\Dal;

use PH7\ApiSimpleMenu\Entity\User as UserEntity;
use RedBeanPHP\R;

final class UserDal
{
    public const TABLE_NAME = 'users';

    /**
     * @throws \RedBeanPHP\RedException\SQL
     */
    public static function create(UserEntity $userEntity): int|string
    {
        $userBean = R::dispense(self::TABLE_NAME);
        $userBean->user_uuid = $userEntity->getUserUuid();
        $userBean->first_name = $userEntity->getFirstName();
        $userBean->last_name = $userEntity->getLastName();
        $userBean->email = $userEntity->getEmail();
        $userBean->phone = $userEntity->getPhone();
        $userBean->created_date = $userEntity->getCreationDate();

        $id = R::store($userBean);

        R::close();

        return $id;
    }
}