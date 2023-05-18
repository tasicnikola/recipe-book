<?php

namespace App\Infrastructure\Symfony\Request\Recipe;

use App\DTO\RequestParams\Collection\IngredientsParams;
use App\DTO\RequestParams\IngredientParams;
use App\DTO\RequestParams\RecipeParams;
use App\Infrastructure\Symfony\Request\NameRequirements;
use App\Infrastructure\Symfony\Request\Request;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Length;
use App\Request\Recipe\Recipe as RecipeRequestInteface;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Url;

class Recipe extends Request implements RecipeRequestInteface
{

    public function params(): RecipeParams
    {
        $ingredientsData = $this->getArrayParameter(self::FIELD_INGREDIENTS);
        $ingredientsObject  = new IngredientsParams(...array_map(fn (array $ingredientData) => new IngredientParams(
            $ingredientData['name'],
        ), $ingredientsData));

        return new RecipeParams(
            $this->getParameter(self::FIELD_TITLE),
            $this->getParameter(self::FIELD_IMAGE_URL),
            $this->getParameter(self::FIELD_DESCRIPTION),
            $this->getParameter(self::FIELD_USER_ID),
            $ingredientsObject
        );
    }

    protected function rules(): Collection
    {
        return new Collection([
            self::FIELD_TITLE => [
                new NameRequirements(),
            ],
            self::FIELD_IMAGE_URL => [
                new Url(),
            ],
            self::FIELD_DESCRIPTION => [
                new Type('string'),
                new Length(
                    min: 10,
                    max: 1000,
                    minMessage: 'Your username must be at least {{ limit }} characters long',
                    maxMessage: 'Your username cannot be longer than {{ limit }} characters',
                ),
            ],
            self::FIELD_INGREDIENTS => [
                new Collection([
                    'name' => [
                        new NameRequirements(),
                    ],
                ])
            ],
        ]);
    }

    protected function  getTableName(): string
    {
        return 'recipes';
    }

    protected function getUnique(): array
    {
        return [self::FIELD_TITLE];
    }
}
