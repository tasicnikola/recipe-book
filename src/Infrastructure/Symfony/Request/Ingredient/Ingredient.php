<?php

namespace App\Infrastructure\Symfony\Request\Ingredient;

use App\DTO\RequestParams\IngredientParams;
use App\Request\Ingredient\Ingredient as IngredientRequestInterface;
use App\Infrastructure\Symfony\Request\Request;
use Symfony\Component\Validator\Constraints\Collection;
use App\Infrastructure\Symfony\Request\NameRequirements;

class Ingredient extends Request implements IngredientRequestInterface
{
    public function params(): IngredientParams
    {
        return new IngredientParams(
            $this->getParameter(self::FIELD_NAME)
        );
    }

    protected function getTableName(): string
    {
        return 'ingredients';
    }

    protected function getUnique(): array
    {
        return [self::FIELD_NAME];
    }


    protected function rules(): Collection
    {
        return new Collection(
            [
                self::FIELD_NAME     => [
                    new NameRequirements(),
                ],
            ]
        );
    }
}
