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
        $recipesData = $this->connection->createQueryBuilder('recipes')
            ->select(
                'r.id as recipe_id',
                'r.title as recipe_title',
                'r.image_url as recipe_image_url',
                'r.description as recipe_description',
                'r.user as recipe_user',
                'r.created_at as recipe_created_at',
                'r.updated_at as recipe_updated_at',
                'i.id as ingredient_id',
                'i.name as ingredient_name',
                'i.created_at as ingredient_created_at',
                'i.updated_at as ingredient_updated_at'
            )
            ->from('recipes', 'r')
            ->innerJoin('r', 'recipe_ingredient', 'ri', 'r.id = ri.recipe_id')
            ->innerJoin('ri', 'ingredients', 'i', 'i.id = ri.ingredient_id')
            ->fetchAllAssociative();

        $recipesWithIngredients = [];
        foreach ($recipesData as $recipeData) {
            $recipeId = $recipeData['recipe_id'];
            if (!isset($recipesWithIngredients[$recipeId])) {
                $recipesWithIngredients[$recipeId] = [
                                                      'data'        => $recipeData,
                                                      'ingredients' => [],
                                                     ];
            }
            $recipesWithIngredients[$recipeId]['ingredients'][] = $this->ingredientQuery->createDTO($recipeData);
        }

        $recipeDTOs = [];
        foreach ($recipesWithIngredients as $recipeWithIngredientsData) {
            $recipeDTOs[] = $this->createDTO($recipeWithIngredientsData['data'], new Ingredients($recipeWithIngredientsData['ingredients']));
        }

        return new Recipes($recipeDTOs);
    }

    public function getById(int $id): ?RecipeDTO
    {
        $recipeData = $this->connection->createQueryBuilder()
            ->select(
                'r.id as recipe_id',
                'r.title as recipe_title',
                'r.image_url as recipe_image_url',
                'r.description as recipe_description',
                'r.user as recipe_user',
                'r.created_at as recipe_created_at',
                'r.updated_at as recipe_updated_at',
                'i.id as ingredient_id',
                'i.name as ingredient_name',
                'i.created_at as ingredient_created_at',
                'i.updated_at as ingredient_updated_at'
            )
            ->from('recipes', 'r')
            ->innerJoin('r', 'recipe_ingredient', 'ri', 'r.id = ri.recipe_id')
            ->innerJoin('ri', 'ingredients', 'i', 'i.id = ri.ingredient_id')
            ->where('r.id = :id')
            ->setParameter('id', $id)
            ->fetchAllAssociative();

        if (false === $recipeData) {
            return null;
        }
        $ingredientsArray = [];

        $recipe = [];
        foreach ($recipeData as $row) {
            $ingredient = [];
            $ingredient['id'] = $row['ingredient_id'];
            $ingredient['name'] = $row['ingredient_name'];
            $ingredient['created_at'] = $row['ingredient_created_at'];
            $ingredient['updated_at'] = $row['ingredient_updated_at'];
            $ingredientsArray[] = $this->ingredientQuery->createDTO($ingredient);

            $recipe['id'] = $row['recipe_id'];
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
            $recipeData['id'],
            $recipeData['title'],
            $recipeData['image_url'],
            $recipeData['description'],
            $this->userQuery->getById($recipeData['user']),
            $ingredients,
            new DateTimeImmutable($recipeData['created_at']),
            $recipeData['updated_at'] ? new DateTime($recipeData['updated_at']) : null,
        );
    }
}
