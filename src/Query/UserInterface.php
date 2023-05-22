<?php

declare(strict_types=1);

namespace App\Query;

use App\DTO\Collection\Users;
use App\DTO\UserDTO;

interface UserInterface
{
    public function getAll(): Users;

    public function get(string $guid): ?UserDTO;

    public function getByEmail(string $email): ?UserDTO;
}
