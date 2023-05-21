<?php

declare(strict_types=1);

namespace App\Exception\NotFound;

class RecipeNotFoundException extends NotFoundException
{
    public function __construct(readonly string $recipeGuid)
    {
        parent::__construct($recipeGuid, 'recipe');
    }
}
