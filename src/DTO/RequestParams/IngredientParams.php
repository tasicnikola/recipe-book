<?php

namespace App\DTO\RequestParams;

class IngredientParams
{
    public function __construct(
        public readonly string $name
    ) {
    }
}
