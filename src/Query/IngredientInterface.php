<?php

declare(strict_types=1);

namespace App\Query;

use App\DTO\Collection\Ingredients;
use App\DTO\IngredientDTO;

interface IngredientInterface
{
    public function getAll(): Ingredients;

    public function get(string $guid): ?IngredientDTO;
}
