<?php

namespace App\Service;

use App\DTO\Collection\Recipes;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Recipe;
use App\DTO\RecipeDTO;
use App\DTO\RequestParams\Parameters;
use App\DTO\RequestParams\RecipeParams;
use App\Entity\User;
use App\Entity\Ingredient;
use App\Entity\RecipeIngredient;
use App\Repository\RecipeRepository;
use App\Repository\RecipeIngredientRepository;
use Exception;
use App\Query\RecipeInterface;
use App\Exception\NotFound\RecipeNotFoundException;

class RecipeService
{
    public function __construct(
        private readonly ManagerRegistry $doctrine,
        private readonly RecipeRepository $recipeRepository,
        private readonly RecipeInterface $query,
        private readonly RecipeIngredientRepository $recipeIngredientRepository
    ) {
    }

    public function get(): ?Recipes
    {
        return $this->query->getAll();
    }

    public function getByID(int $id): ?RecipeDTO
    {
        return $this->query->getByID($id);
    }

    public function create(RecipeParams $recipeParams): int
    {
        $recipe = (new Recipe())
            ->setTitle($recipeParams->title)
            ->setImageUrl($recipeParams->image)
            ->setDescription($recipeParams->description)
            ->setUser($this->findUser($recipeParams->user));

        $recipeId = $this->recipeRepository->save($recipe);
        $this->setRecipeIngredients($recipeParams->ingredients, $recipe);

        return $recipeId;
    }

    public function delete(int $id): void
    {
        $recipe = $this->findRecipe($id);

        $this->recipeRepository->remove($recipe);
    }

    private function findRecipe(int $id): Recipe
    {
        $recipe = $this->recipeRepository->find($id);

        if (null === $recipe) {
            throw new RecipeNotFoundException($id);
        }

        return $recipe;
    }

    public function update(int $id, Parameters $recipeParams): void
    {
        $recipe = ($this->recipeRepository->find($id))
            ->setTitle($recipeParams->title)
            ->setImageUrl($recipeParams->image)
            ->setDescription($recipeParams->description)
            ->setUser($this->findUser($recipeParams->user));

        $this->recipeIngredientRepository->delete($id);
        $this->setRecipeIngredients($recipeParams->ingredients, $recipe);
        $this->recipeRepository->update($recipe);
    }

    private function setRecipeIngredients(array $ingredients, Recipe $entity): void
    {
        foreach ($ingredients as $ingredient) {
            $ingredientId = $this->doctrine->getRepository(Ingredient::class)->find($ingredient['ingredient']);
            $recipeIngredient = (new RecipeIngredient())
                ->setAmount($ingredient['amount'])
                ->setRecipe($entity)
                ->setIngredient($ingredientId);

            $this->recipeIngredientRepository->save($recipeIngredient);
        }
    }

    private function findUser(int $id): User
    {
        return $this->doctrine->getRepository(User::class)->find($id);
    }
}
