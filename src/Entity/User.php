<?php
/**
 * @author     Pierre-Henry Soria <hi@ph7.me>
 * @website    https://ph7.me
 * @license    MIT License
 */

declare(strict_types=1);

namespace PH7\ApiSimpleMenu\Entity;

class User implements Entitable
{
    private int $sequentialId;
    private ?string $userUuid = null;

    private ?string $firstName = null;

    private ?string $lastName = null;

    private ?string $email = null;

    private ?string $phone = null;

    private string $password;

    private ?string $creationDate = null;

    public function setSequentialId(int $sequentialId): self
    {
        $this->sequentialId = $sequentialId;

        return $this;
    }

    public function getSequentialId(): int
    {
        return $this->sequentialId;
    }

    public function setUserUuid(string $userUuid) :self
    {
        $this->userUuid = $userUuid;

        return $this;
    }

    public function getUserUuid(): ?string
    {
        return $this->userUuid;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setCreationDate(string $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getCreationDate(): ?string
    {
        return $this->creationDate;
    }

    public function unserialize(?array $data): self
    {
        if (!empty($data['id'])) {
            $sequentialId = (int)$data['id'];
            $this->setSequentialId($sequentialId);
        }

        if (!empty($data['user_uuid'])) {
            $this->setUserUuid($data['user_uuid']);
        }

        if (!empty($data['first_name'])) {
            $this->setFirstName($data['first_name']);
        }

        if (!empty($data['last_name'])) {
            $this->setLastName($data['last_name']);
        }

        if (!empty($data['email'])) {
            $this->setEmail($data['email']);
        }

        if (!empty($data['phone'])) {
            $this->setPhone($data['phone']);
        }

        if (!empty($data['password'])) {
            $this->setPassword($data['password']);
        }

        if (!empty($data['created_date'])) {
            $this->setCreationDate($data['created_date']);
        }

        return $this;
    }

//    public function serialize(): array
//    {
//        // optional. we could also only return the properties we want to make it safe
//        // (not all properties should indeed be returned)
//        return get_object_vars($this);
//    }
}
