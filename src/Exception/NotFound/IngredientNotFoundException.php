<?php

declare(strict_types=1);

namespace App\Exception\NotFound;

class IngredientNotFoundException extends NotFoundException
{
    public function __construct(readonly string $ingredientGuid)
    {
        parent::__construct($ingredientGuid, 'ingredient');
    }
}
