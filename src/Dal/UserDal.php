<?php

namespace PH7\ApiSimpleMenu\Dal;

use PH7\ApiSimpleMenu\Entity\User as UserEntity;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;

final class UserDal
{
    public const TABLE_NAME = 'users';

    public static function create(UserEntity $userEntity): int|string|false
    {
        $userBean = R::dispense(self::TABLE_NAME);
        $userBean->user_uuid = $userEntity->getUserUuid();
        $userBean->first_name = $userEntity->getFirstName();
        $userBean->last_name = $userEntity->getLastName();
        $userBean->email = $userEntity->getEmail();
        $userBean->phone = $userEntity->getPhone();
        $userBean->password = $userEntity->getPassword();
        $userBean->created_date = $userEntity->getCreationDate();

        try {
            $redBeanIncrementId = R::store($userBean);
        } catch (SQL $e) {
            return false;
        } finally {
            R::close();
        }

        return $redBeanIncrementId;
    }

    public static function update(string $userUuid, UserEntity $userEntity): int|string|false
    {
        $userBean = R::findOne(self::TABLE_NAME, 'user_uuid = :userUuid', ['userUuid' => $userUuid]);

        // If the user exists, update it
        if ($userBean) {
            $firstName = $userEntity->getFirstName();
            $lastName = $userEntity->getLastName();
            $phone = $userEntity->getPhone();

            if ($firstName) {
                $userBean->firstName = $firstName;
            }

            if ($lastName) {
                $userBean->lastName = $lastName;
            }

            if ($phone) {
                $userBean->phone = $phone;
            }

            // save the user
            try {
                return R::store($userBean);
            } catch (SQL $e) {
                return false;
            } finally {
                R::close();
            }
        }

        return false;
    }

    public static function getById(string $userUuid): ?array
    {
        $bindings = ['userUuid' => $userUuid];
        $userBean = R::findOne(self::TABLE_NAME, 'user_uuid = :userUuid ', $bindings);

       return $userBean?->export();
    }

    public static function getByEmail(string $email): ?array
    {
        $bindings = ['email' => $email];

        $userBean = R::findOne(self::TABLE_NAME, 'email = :email', $bindings);

        return $userBean?->export();
    }

    public static function getAll(): array
    {
        return R::findAll(self::TABLE_NAME);
    }

    public static function remove(string $userUuid): bool
    {
        $userBean = R::findOne(self::TABLE_NAME, 'user_uuid = :userUuid', ['userUuid' => $userUuid]);

        if ($userBean) {
            return (bool)R::trash($userBean);
        }

        return false;
    }

    public static function doesEmailExist(string $email): bool
    {
        // If R::findOne doesn't find any rows, it returns NULL (meaning, the email address doesn't exist)
        return R::findOne(self::TABLE_NAME, 'email = :email', ['email' => $email]) !== null;
    }
}