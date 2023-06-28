<?php

namespace PH7\ApiSimpleMenu\Entity;

interface Entitable
{
    public function unserialize(?array $data): self;

    public function setSequentialId(int $sequentialId): self;

    public function getSequentialId(): int;
}