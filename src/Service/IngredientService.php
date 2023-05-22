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

    public function getAll(): ?Ingredients
    {
        return $this->query->getAll();
    }

    public function get(string $guid): ?IngredientDTO
    {
        $ingredient = $this->query->get($guid);

        if (null === $ingredient) {
            throw new IngredientNotFoundException($guid);
        }

        return $ingredient;
    }

    public function create(IngredientParams $params): int
    {
        $ingredient = $this->repository->getEntityInstance();
        $ingredient->update($params);
        $this->repository->save($ingredient);

        return $ingredient->getGuid();
    }

    public function delete(string $guid): void
    {
        $ingredient = $this->findIngredient($guid);
        $this->repository->remove($ingredient);
    }

    public function update(string $guid, IngredientParams $params): void
    {
        $ingredient = $this->findIngredient($guid);
        $ingredient->update($params);
        $this->repository->save($ingredient);
    }

    private function findIngredient(string $guid): Ingredient
    {
        $ingredient = $this->repository->find($guid);

        if (null === $ingredient) {
            throw new IngredientNotFoundException($guid);
        }

        return $ingredient;
    }
}
