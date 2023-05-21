<?php

namespace App\DTO;

use App\DTO\Collection\Ingredients;
use App\DTO\UserDTO;
use DateTime;
use DateTimeImmutable;
use JsonSerializable;

class RecipeDTO implements JsonSerializable
{
    public function __construct(
        public string $guid,
        public string $title,
        public string $imageUrl,
        public string $description,
        public UserDTO $user,
        public ?Ingredients $ingredients,
        public DateTimeImmutable $createdAt,
        public ?DateTime $updatedAt,
    ) {
    }

    public function jsonSerialize(): array
    {
        return  [
            'guid'        => $this->guid,
            'title'       => $this->title,
            'image'       => $this->imageUrl,
            'description' => $this->description,
            'user'        => $this->user,
            'ingredients' => $this->ingredients,
            'created_at'  => $this->createdAt,
            'updated_at'  => $this->updatedAt,
        ];
    }
}
