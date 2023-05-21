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
use Symfony\Component\Validator\Constraints\All;

class Recipe extends Request implements RecipeRequestInteface
{
    public function params(): RecipeParams
    {
        $ingredientsData = $this->getArrayParameter(self::FIELD_INGREDIENTS);
        $ingredientsObject  = new IngredientsParams(
            ...array_map(
                fn (array $ingredientData) => new IngredientParams(
                    $ingredientData['name'],
                ),
                $ingredientsData
            )
        );

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
        return new Collection(
            [
                self::FIELD_TITLE       => [
                    new NameRequirements(),
                ],
                self::FIELD_IMAGE_URL   => [
                    new Url(),
                ],
                self::FIELD_DESCRIPTION => [
                    new Type('string'),
                    new Length(
                        min: 8,
                        max: 1024,
                        minMessage: 'Your description must be at least {{ limit }} characters long',
                        maxMessage: 'Your description cannot be longer than {{ limit }} characters',
                    ),
                ],
                self::FIELD_USER_ID => [
                    new Type(['type' => 'numeric'])
                ],
                self::FIELD_INGREDIENTS => [
                    new All([
                        new Collection([
                            'name' => [
                                new NameRequirements(),
                            ],
                        ]),
                    ]),
                ],
            ]
        );
    }

    protected function getTableName(): string
    {
        return 'recipes';
    }

    protected function getUnique(): array
    {
        return [self::FIELD_TITLE];
    }
}
