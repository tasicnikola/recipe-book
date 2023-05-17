<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Query;

use App\DTO\Collection\Ingredients;
use App\DTO\IngredientDTO;
use App\Query\IngredientInterface;
use DateTime;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;

class Ingredient implements IngredientInterface
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    public function getAll(): Ingredients
    {
        $ingredientsData = $this->connection->createQueryBuilder('ingredients')
            ->select(
                'id',
                'name',
                'created_at',
                'updated_at'
            )
            ->from('ingredients')
            ->orderBy('name', 'ASC')
            ->fetchAllAssociative();

        return new Ingredients(array_map(fn (array $ingredientData) => $this->createDTO($ingredientData), $ingredientsData));
    }

    public function getById(int $id): ?IngredientDTO
    {
        $ingredientData = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name',
                'created_at',
                'updated_at'
            )
            ->from('ingredients')
            ->where('id = ?')
            ->setParameter(0, $id)
            ->fetchAssociative();

        if (false === $ingredientData) {
            return null;
        }

        return $this->createDTO($ingredientData);
    }

    private function createDTO(array $ingredientData): IngredientDTO
    {
        return new IngredientDTO(
            $ingredientData['id'],
            $ingredientData['name'],
            new DateTimeImmutable($ingredientData['created_at']),
            $ingredientData['updated_at'] ? new DateTime($ingredientData['updated_at']) : null,
        );
    }
}
