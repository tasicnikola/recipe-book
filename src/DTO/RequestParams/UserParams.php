<?php

declare(strict_types=1);

namespace App\DTO\RequestParams;

class UserParams
{
    public function __construct(
        public readonly string $name,
        public readonly string $surname,
        public readonly string $email,
        public readonly string $username,
        public readonly string $password,
    ) {
    }
}
