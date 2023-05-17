<?php

declare(strict_types=1);

namespace App\Exception\NotFound;

class RecipeNotFoundException extends NotFoundException
{
    public function __construct(readonly int $recipeId)
    {
        parent::__construct($recipeId, 'recipe');
    }
}
