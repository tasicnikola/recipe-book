<?php

declare(strict_types=1);

namespace App\Query;

use App\DTO\Collection\Recipes;
use App\DTO\RecipeDTO;

interface RecipeInterface
{
    public function getAll(): ?Recipes;

    public function getByGuid(string $guid): ?RecipeDTO;
}
