<?php

namespace App\DTO;

use DateTime;
use DateTimeImmutable;
use JsonSerializable;

class IngredientDTO implements JsonSerializable
{
    public function __construct(
        public int $id,
        public string $name,
        public DateTimeImmutable $createdAt,
        public ?DateTime $updatedAt,
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
