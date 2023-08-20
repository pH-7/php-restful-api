<?php
/**
 * Miscellaneous file (MISC)
 *
 * @author     Pierre-Henry Soria <hi@ph7.me>
 * @license    MIT License
 */

declare(strict_types=1);

const PASSWORD_COST_FACTOR = 12;

function response(mixed $data): void {
    echo json_encode($data);
}

function hashPassword(string $password): false|null|string {
   return password_hash($password, PASSWORD_ARGON2I, ['cost' => PASSWORD_COST_FACTOR]);
}
