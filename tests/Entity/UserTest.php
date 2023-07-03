<?php

declare(strict_types=1);

namespace PH7\ApiSimpleMenu\Tests\Entity;

use PH7\ApiSimpleMenu\Entity\User as UserEntity;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class UserTest extends TestCase
{
    private UserEntity $userEntity;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userEntity = new UserEntity();
    }

    public function testSequentialId(): void
    {
        $expectedSequentialId = 55;

        $this->userEntity->setSequentialId($expectedSequentialId);

        $this->assertSame($expectedSequentialId, $this->userEntity->getSequentialId());
    }

    public function testUserUuid(): void
    {
        $uuid = Uuid::uuid4()->toString();

        $this->userEntity->setUserUuid($uuid);

        $this->assertSame($uuid, $this->userEntity->getUserUuid());
    }

    public function testUnserialize(): void
    {
        $expectUserData = [
            'id' => 5,
            'user_uuid' => Uuid::uuid4()->toString(),
            'first_name' => 'Pierre',
            'last_name' => 'Soria',
            'email' => 'me@ph7.me',
            'phone' => '043983934',
            'password' => 'chicken',
            'created_date' => '2023-07-01 19:59:55'
        ];

        $this->userEntity->unserialize($expectUserData);

        // assertions
        $this->assertSame($expectUserData['id'], $this->userEntity->getSequentialId());
        $this->assertSame($expectUserData['user_uuid'], $this->userEntity->getUserUuid());
        $this->assertSame($expectUserData['first_name'], $this->userEntity->getFirstName());
        $this->assertSame($expectUserData['last_name'], $this->userEntity->getLastName());
        $this->assertSame($expectUserData['email'], $this->userEntity->getEmail());
        $this->assertSame($expectUserData['phone'], $this->userEntity->getPhone());
        $this->assertSame($expectUserData['password'], $this->userEntity->getPassword());
        $this->assertSame($expectUserData['created_date'], $this->userEntity->getCreationDate());
    }
}