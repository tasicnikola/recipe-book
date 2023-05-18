<?php

namespace App\DTO\RequestParams;

use App\DTO\RequestParams\Collection\IngredientsParams;

class RecipeParams
{
    public function __construct(
        public readonly string $title,
        public readonly string $image,
        public readonly string $description,
        public readonly int $user,
        public readonly IngredientsParams $ingredients
    ) {
    }
}
