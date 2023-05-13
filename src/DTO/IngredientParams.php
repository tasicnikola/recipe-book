<?php

namespace App\DTO;

use App\DTO\Parameters;

class IngredientParams implements Parameters
{
    public function __construct(public string $name)
    {
    }

    public function jsonSerialize(): array
    {
        return [
                'name' => $this->name,
               ];
    }
}
