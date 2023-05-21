<?php

namespace App\DTO;

use DateTime;
use DateTimeImmutable;
use JsonSerializable;

class IngredientDTO implements JsonSerializable
{
    public function __construct(
        public string $guid,
        public string $name,
        public DateTimeImmutable $createdAt,
        public ?DateTime $updatedAt,
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
                'guid'         => $this->guid,
                'name'       => $this->name,
                'created_at' => $this->createdAt,
                'updated_at' => $this->updatedAt,
               ];
    }
}
