<?php

declare(strict_types=1);

namespace App\Request\Ingredient;

use App\DTO\RequestParams\IngredientParams;
use App\Request\Field\Id;
use App\Request\Field\Name;

interface Ingredient extends Id, Name
{
    public function params(): IngredientParams;
}
