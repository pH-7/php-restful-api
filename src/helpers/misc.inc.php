<?php
// miscellaneous file (MISC)

const PASSWORD_COST_FACTOR = 12;

function response($data): void {
    echo json_encode($data);
}

function hashPassword(string $password): false|null|string {
   return password_hash($password, PASSWORD_ARGON2I, ['cost' => PASSWORD_COST_FACTOR]);
}