<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Query;

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
    ){
    }

    public function getAll() : ?Recipes
    {
        $recipesData = $this->connection->createQueryBuilder('recipes')
            ->select(
                'id',
                'user',
                'title',
                'image_url',
                'description',
                'created_at',
                'updated_at',
                'ingredients'
            )
            ->from('recipes')
            ->fetchAllAssociative();
        
        return new Recipes(array_map(fn(array $recipeData) => $this->createDTO($recipeData), $recipesData));
    }

    public function getById(int $id) : ?RecipeDTO
    {
        $recipeData = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'user',
                'title',
                'image_url',
                'description',
                'created_at',
                'updated_at',
                'ingredients'
            )
            ->from('recipes')
            ->where('id =  ?')
            ->setParameter(0, $id)
            ->fetchAssociative();

        if(false === $recipeData) {
            return null;
        }

        return $this->createDTO($recipeData);
    }

    private function createDTO(array $recipeData) : RecipeDTO
    {
        return new RecipeDTO(
            $recipeData['id'],
            $recipeData['user'],
            // User::from($recipeData['user']),
            $recipeData['title'],
            $recipeData['image_url'],
            $recipeData['description'],
            new DateTimeImmutable($recipeData['created_at']),
            $recipeData['updated_at'] ? new DateTime($recipeData['updated_at']) : null,
            $recipeData['ingredients'],
        );
    }
}