<?php

namespace App\Service;

use App\Exception\CustomException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\Filesystem\Filesystem;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Recipe;
use App\DTO\RecipeDTO;
use App\DTO\Parameters;
use App\Entity\User;
use App\Entity\Ingredient;
use App\Entity\RecipeIngredient;
use App\Repository\RecipeRepository;
use App\Repository\RecipeIngredientRepository;
use Exception;
use App\Service\RetrieveInterface;
use App\Service\CreateInterface;
use App\Service\DeleteInterface;
use App\Service\UpdateInterface;

class RecipeService implements
    RetrieveInterface,
    CreateInterface,
    DeleteInterface,
    UpdateInterface
{
public function __construct(
    private readonly ManagerRegistry $doctrine,
    private readonly RecipeRepository $recipeRepository,
    private readonly RecipeIngredientRepository $recipeIngredientRepository
    )
    {}

    public function get(): ?array
    {
        return $this->recipeRepository->getAll();
    }

    public function getByID(int $id): ?RecipeDTO
    {
        return $this->recipeRepository->get($id);
    }

    public function create(Parameters $recipeParams): int
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
        $this->recipeRepository->delete($id);
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
