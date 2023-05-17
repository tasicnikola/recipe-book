<?php

namespace App\Service;

use App\DTO\Collection\Ingredients;
use App\Entity\Ingredient;
use App\DTO\IngredientDTO;
use App\DTO\RequestParams\IngredientParams;
use App\Query\IngredientInterface;
use App\Repository\IngredientRepository;
use App\Exception\NotFound\IngredientNotFoundException;

class IngredientService
{
    public function __construct(
        private IngredientRepository $repository,
        private readonly IngredientInterface $query
    ) {
    }

    public function get(): ?Ingredients
    {
        return $this->query->getAll();
    }

    public function getByID(int $id): ?IngredientDTO
    {
        $ingredient = $this->query->getByID($id);

        if (null === $ingredient) {
            throw new IngredientNotFoundException($id);
        }

        return $ingredient;
    }

    public function create(IngredientParams $params): int
    {
        $ingredient = $this->repository->getEntityInstance();
        $ingredient->update($params);
        $this->repository->save($ingredient);

        return $ingredient->getId();
    }

    public function delete(int $id): void
    {
        $ingredient = $this->findIngredient($id);
        $this->repository->remove($ingredient);
    }

    public function update(int $id, IngredientParams $params): void
    {
        $ingredient = $this->findIngredient($id);
        $ingredient->update($params);
        $this->repository->save($ingredient);
    }

    private function findIngredient(int $id): Ingredient
    {
        $ingredient = $this->repository->find($id);

        if (null === $ingredient) {
            throw new IngredientNotFoundException($id);
        }

        return $ingredient;
    }
}
