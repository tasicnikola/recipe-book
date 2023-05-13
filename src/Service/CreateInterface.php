<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use App\DTO\IngredientDTO;
use App\DTO\RecipeDTO;
use App\DTO\Parameters;

interface CreateInterface
{
    public function create(Parameters $params): int;
}
