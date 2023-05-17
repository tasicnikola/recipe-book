<?php

declare(strict_types=1);

namespace App\DTO\Collection;

use JsonSerializable;

class Ingredients implements JsonSerializable
{
    public function __construct(
        public readonly array $ingredients
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return $this->ingredients;
    }
}
