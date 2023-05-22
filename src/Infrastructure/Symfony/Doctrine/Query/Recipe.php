<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Query;

use App\DTO\Collection\Ingredients;
use App\DTO\Collection\Recipes;
use App\DTO\RecipeDTO;
use App\Query\RecipeInterface;
use Doctrine\DBAL\Connection;
use DateTime;
use DateTimeImmutable;

class Recipe implements RecipeInterface
{
    public function __construct(
        private readonly Connection $connection,
        private readonly User $userQuery,
        private readonly Ingredient $ingredientQuery
    ) {
    }

    public function getAll(): ?Recipes
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select(
                'r.guid as recipe_guid',
                'r.title as recipe_title',
                'r.image_url as recipe_image_url',
                'r.description as recipe_description',
                'r.user as recipe_user',
                'r.created_at as recipe_created_at',
                'r.updated_at as recipe_updated_at',
                'i.guid as ingredient_guid',
                'i.name as ingredient_name',
                'i.created_at as ingredient_created_at',
                'i.updated_at as ingredient_updated_at'
            )
            ->from('recipes', 'r')
            ->innerJoin('r', 'recipe_ingredient', 'ri', 'r.guid = ri.recipe_guid')
            ->innerJoin('ri', 'ingredients', 'i', 'i.guid = ri.ingredient_guid');

        $recipesData = $queryBuilder->fetchAllAssociative();

        $recipesWithIngredients = [];
        foreach ($recipesData as $recipeData) {
            $recipeId = $recipeData['recipe_guid'];
            if (!isset($recipesWithIngredients[$recipeId])) {
                $recipesWithIngredients[$recipeId] = [
                    'data' => [
                        'guid' => $recipeData['recipe_guid'],
                        'title' => $recipeData['recipe_title'],
                        'image_url' => $recipeData['recipe_image_url'],
                        'description' => $recipeData['recipe_description'],
                        'user' => $recipeData['recipe_user'],
                        'created_at' => $recipeData['recipe_created_at'],
                        'updated_at' => $recipeData['recipe_updated_at'],
                    ],
                    'ingredients' => [],
                ];
            }
            $ingredient = [
                'guid' => $recipeData['ingredient_guid'],
                'name' => $recipeData['ingredient_name'],
                'created_at' => $recipeData['ingredient_created_at'],
                'updated_at' => $recipeData['ingredient_updated_at'],
            ];
            $recipesWithIngredients[$recipeId]['ingredients'][] = $this->ingredientQuery->createDTO($ingredient);
        }

        $recipeDTOs = [];
        foreach ($recipesWithIngredients as $recipeWithIngredientsData) {
            $recipeDTOs[] = $this->createDTO($recipeWithIngredientsData['data'], new Ingredients($recipeWithIngredientsData['ingredients']));
        }

        return new Recipes($recipeDTOs);
    }

    public function get(string $guid): ?RecipeDTO
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select(
                'r.guid as recipe_guid',
                'r.title as recipe_title',
                'r.image_url as recipe_image_url',
                'r.description as recipe_description',
                'r.user as recipe_user',
                'r.created_at as recipe_created_at',
                'r.updated_at as recipe_updated_at',
                'i.guid as ingredient_guid',
                'i.name as ingredient_name',
                'i.created_at as ingredient_created_at',
                'i.updated_at as ingredient_updated_at'
            )
            ->from('recipes', 'r')
            ->innerJoin('r', 'recipe_ingredient', 'ri', 'r.guid = ri.recipe_guid')
            ->innerJoin('ri', 'ingredients', 'i', 'i.guid = ri.ingredient_guid')
            ->where('r.guid = :recipeId')
            ->setParameter('recipeId', $guid);

        $recipeData = $queryBuilder->fetchAllAssociative();

        if (empty($recipeData)) {
            return null;
        }

        $ingredientsArray = [];
        $recipe = [];

        foreach ($recipeData as $row) {
            $ingredient = [
                'guid' => $row['ingredient_guid'],
                'name' => $row['ingredient_name'],
                'created_at' => $row['ingredient_created_at'],
                'updated_at' => $row['ingredient_updated_at'],
            ];
            $ingredientsArray[] = $this->ingredientQuery->createDTO($ingredient);

            $recipe['guid'] = $row['recipe_guid'];
            $recipe['title'] = $row['recipe_title'];
            $recipe['image_url'] = $row['recipe_image_url'];
            $recipe['description'] = $row['recipe_description'];
            $recipe['user'] = $row['recipe_user'];
            $recipe['created_at'] = $row['recipe_created_at'];
            $recipe['updated_at'] = $row['recipe_updated_at'];
            $recipe['ingredients'][] = $ingredient;
        }

        return $this->createDTO($recipe, new Ingredients($ingredientsArray));
    }

    private function createDTO(array $recipeData, Ingredients $ingredients): RecipeDTO
    {
        return new RecipeDTO(
            $recipeData['guid'],
            $recipeData['title'],
            $recipeData['image_url'],
            $recipeData['description'],
            $this->userQuery->get($recipeData['user']),
            $ingredients,
            new DateTimeImmutable($recipeData['created_at']),
            $recipeData['updated_at'] ? new DateTime($recipeData['updated_at']) : null,
        );
    }
}
