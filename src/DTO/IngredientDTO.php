<?php

namespace App\DTO;

use App\DTO\RequestParams\Parameters;

class IngredientDTO implements \JsonSerializable
{
    public function __construct(public int $id, public string $name)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
        ];
    }
}
