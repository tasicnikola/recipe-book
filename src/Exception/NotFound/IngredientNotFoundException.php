<?php

declare(strict_types=1);

namespace App\Exception\NotFound;

class IngredientNotFoundException extends NotFoundException
{
    public function __construct(readonly int $ingredientId)
    {
        parent::__construct($ingredientId, 'ingredient');
    }
}
