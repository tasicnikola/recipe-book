<?php

namespace App\DTO;

use App\Entity\User;
use App\DTO\Parameters;

class RecipeDTO implements \JsonSerializable
{
    public function __construct(
        public int $id,
        public string $title,
        public string $image,
        public string $description,
        public User $user,
        public ?string $created,
        public ?string $updated,
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
            'created' => $this->created,
            'updated' => $this->updated,
            'ingredients' => $this->ingredients,
        ];
    }
}
