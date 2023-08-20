<?php
/**
 * @author     Pierre-Henry Soria <hi@ph7.me>
 * @website    https://ph7.me
 * @license    MIT License
 */

declare(strict_types=1);

namespace PH7\ApiSimpleMenu\Entity;

interface Entitable
{
    public function unserialize(?array $data): self;

    public function setSequentialId(int $sequentialId): self;

    public function getSequentialId(): int;
}
