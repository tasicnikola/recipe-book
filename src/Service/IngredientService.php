<?php

namespace App\Service;

use App\Exception\CustomException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\Filesystem\Filesystem;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Ingredient;
use App\DTO\IngredientDTO;
use App\DTO\Parameters;
use App\Repository\IngredientRepository;
use Exception;
use App\Service\RetrieveInterface;
use App\Service\CreateInterface;
use App\Service\DeleteInterface;
use App\Service\UpdateInterface;

class IngredientService implements
    RetrieveInterface,
    CreateInterface,
    DeleteInterface,
    UpdateInterface
{
    public function __construct(private IngredientRepository $repository)
    {}

    public function get(): ?array
    {
        return $this->repository->getAll();
    }

    public function getByID(int $id): ?IngredientDTO
    {
        return $this->repository->get($id);
    }

    public function create(Parameters $ingredientParams): int
    {
        $ingredient = new Ingredient();
        $ingredient->setName($ingredientParams->name);

        return $this->repository->save($ingredient);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    public function update(int $id, Parameters $ingredientParams): void
    {
        $ingredient = $this->repository->find($id);
        $ingredient->setName($ingredientParams->name);

        $this->repository->update($ingredient);
    }
}
