<?php

namespace PH7\ApiSimpleMenu\Entity;

class User
{
    private string $userUuid;

    private ?string $firstName = null;

    private ?string $lastName = null;

    private ?string $email = null;

    private ?string $phone = null;

    private string $password;

    private string $creationDate;

    public function setUserUuid(string $userUuid) :self
    {
        $this->userUuid = $userUuid;

        return $this;
    }

    public function getUserUuid(): string
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

    public function getCreationDate(): string
    {
        return $this->creationDate;
    }
}