<?php

declare(strict_types=1);

namespace App\DTO;

use DateTime;
use DateTimeImmutable;
use JsonSerializable;

class UserDTO implements \JsonSerializable
{
    public function __construct(
        public string $id,
        public string $username,
        public string $password,
        public string $name,
        public string $surname,
        public string $email,
        public string $created,
        public ?string $updated,
        )
    {}

    public function jsonSerialize(): mixed
    {
        return  [
            'id' => $this->id,
            'username' => $this->username,
            'password' => $this->password,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'created' => $this->created,
            'updated' => $this->updated,
        ];
    }
}
