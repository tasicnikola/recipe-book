<?php

namespace App\DTO\RequestParams;

use App\DTO\RequestParams\Parameters;

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
