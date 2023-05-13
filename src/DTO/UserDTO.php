<?php

namespace App\DTO;

use App\Entity\Role;
use App\DTO\RequestParams\Parameters;

class UserDTO implements \JsonSerializable
{
    public function __construct(
        public int $id,
        public string $username,
        public string $password,
        public string $name,
        public string $surname,
        public string $email,
        public string $created,
        public string $updated,
        public Role $role
        )
    {}

    public function jsonSerialize(): array
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
            'role' => $this->role,
        ];
    }
}
