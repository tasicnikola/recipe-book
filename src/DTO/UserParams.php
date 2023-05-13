<?php

declare(strict_types=1);

namespace App\DTO;

use App\DTO\Parameters;

class UserParams implements Parameters
{
public function __construct(
    public readonly string $username,
    public readonly string $password,
    public readonly string $name,
    public readonly string $surname,
    public readonly string $email,
    public readonly int $role,
    )
    {}
}
