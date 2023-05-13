<?php

namespace App\DTO;

use App\Entity\User;
use App\DTO\Parameters;

class RecipeParams implements Parameters
{
    public function __construct(
        public string $title,
        public string $image,
        public string $description,
        public int $user,
        public array $ingredients
    ) {
    }
}
