<?php

namespace App\DTO;

use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use JsonSerializable;

class RecipeDTO implements \JsonSerializable
{
    public function __construct(
        public int $id,
        public string $title,
        public string $image,
        public string $description,
        public User $user,
        public DateTimeImmutable $createdAt,
        public ?DateTime $updatedAt,
        public array $ingredients
        )
    {}

    public function jsonSerialize(): array
    {
        return  [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'description' => $this->description,
            'user' => $this->user,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'ingredients' => $this->ingredients,
        ];
    }
}
