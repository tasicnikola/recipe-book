<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\Trait\RemoveTrait;
use App\Repository\Trait\SaveTrait;

class RecipeRepository extends ServiceEntityRepository implements RepositoryInterface
{
    use SaveTrait;
    use RemoveTrait;

    public function __construct(
        private ManagerRegistry $doctrine
    ) {
        parent::__construct($doctrine, Recipe::class);
    }

    public function getEntityInstance(): Recipe
    {
        return new Recipe();
    }
}
