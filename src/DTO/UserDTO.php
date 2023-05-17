<?php

declare(strict_types=1);

namespace App\DTO;

use DateTime;
use DateTimeImmutable;
use JsonSerializable;

class UserDTO implements JsonSerializable
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $surname,
        public readonly string $email,
        public readonly string $username,
        public readonly string $password,
        public DateTimeImmutable $createdAt,
        public ?DateTime $updatedAt,
        )
    {}

    public function jsonSerialize(): mixed
    {
        return  [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'username' => $this->username,
            'password' => $this->password,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
