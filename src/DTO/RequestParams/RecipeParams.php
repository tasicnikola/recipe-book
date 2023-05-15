<?php

namespace App\DTO\RequestParams;

use App\DTO\RequestParams\Parameters;

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
