<?php

declare(strict_types=1);

namespace App\DTO\Collection;

use JsonSerializable;

class Recipes implements JsonSerializable
{
    public function __construct(
        public readonly array $recipes
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return $this->recipes;
    }
}
