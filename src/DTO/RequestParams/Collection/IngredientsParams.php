<?php

namespace App\DTO\RequestParams\Collection;

use App\DTO\RequestParams\IngredientParams;

class IngredientsParams
{
    public readonly array $params;
    public function __construct(IngredientParams ...$ingredientsParams)
    {
        $this->params = $ingredientsParams;
    }
}
