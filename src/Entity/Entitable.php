<?php

namespace PH7\ApiSimpleMenu\Entity;

interface Entitable
{
    public function unserialize(?array $data): self;

    public function setSequentialId(int $sequentialId): void;

    public function getSequentialId(): int;
}