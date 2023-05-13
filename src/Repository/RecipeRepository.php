<?php

namespace App\Repository;

use App\Entity\RecipeIngredient;
use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;
use App\Repository\RecipeIngredientRepository;
use Symfony\Component\Config\Definition\Exception\Exception;
use App\DTO\RecipeDTO;
use Doctrine\ORM\QueryBuilder;


/**
 * @extends ServiceEntityRepository<Recipe>
 *
 * @method Recipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipe[]    findAll()
 * @method Recipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(
        private ManagerRegistry $doctrine
    )
    {
        parent::__construct($doctrine, Recipe::class);
    }

    public function save(Recipe $entity): int
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity->getId();
    }

    public function update(Recipe $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function get(int $id): ?RecipeDTO
    {
        $query = $this->selectRecipes()
            ->where('r.id = :id')
            ->setParameter('id', $id)
            ->getQuery();
        $recipe = $query->getOneOrNullResult();

        if ($recipe === null) {
            throw new Exception("Recipe with id: $id not found");
        }

        return $this->createDTO($recipe);
    }

    public function delete(int $id) : void
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        $query->delete(RecipeIngredient::class, 'r')
           ->where('r.recipe = :id')
           ->setParameter('id', $id)
           ->getQuery()
           ->execute();

        $query->delete(Recipe::class, 'r')
           ->where('r.id = :id')
           ->setParameter('id', $id)
           ->getQuery()
           ->execute();
    }

    public function getAll() : array
    {
        $query = $this->selectRecipes()
            ->getQuery();
        $recipes = $query->getResult();
        foreach ($recipes as $recipe) {
            $recipesArray[] = $this->createDTO($recipe);
        }
        
        return $recipesArray;
    }

    private function getRecipeIngredients(int $id) : array
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('Ingredient.name')
            ->from(Ingredient::class, 'Ingredient')
            ->join(
                RecipeIngredient::class,
                'RecipeIngredient',
                Join::WITH,
                'RecipeIngredient.ingredient = Ingredient.id'
            )
            ->where('RecipeIngredient.recipe = :id')
            ->setParameter('id', $id);
        $ingredientsQuery = $queryBuilder->getQuery();
        $ingredients = $ingredientsQuery->getResult();

        $queryBuilder->resetDQLPart('select');
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('RecipeIngredient.amount')
            ->from(RecipeIngredient::class, 'RecipeIngredient')
            ->where('RecipeIngredient.recipe = :id')
            ->setParameter('id', $id);
        $amountsQuery = $queryBuilder->getQuery();
        $amounts = $amountsQuery->getResult();

        return [$ingredients, $amounts];
    }

    private function selectRecipes() : QueryBuilder
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('r')
            ->from(Recipe::class, 'r');
    }

    private function createIngredientsObject(Recipe $recipe) : array
    {
        list($ingredients, $amounts) = $this->getRecipeIngredients($recipe->getId());
        $ingredientsObject = [];
        foreach ($ingredients as $index => $ingredient) {
            $amount = $amounts[$index]['amount'];
            $name = $ingredient['name'];
            $ingredientsObject[] = [
                'name' => $name,
                'amount' => $amount,
            ];
        }

        return $ingredientsObject;
    }

    private function createDTO(Recipe $recipe) : RecipeDTO
    {
        return new RecipeDTO(
            $recipe->getId(),
            $recipe->getTitle(),
            $recipe->getImageUrl(),
            $recipe->getDescription(),
            $recipe->getUser(),
            $recipe->getCreated()->format('date_format'),
            $recipe->getUpdated()->format('date_format'),
            $this->createIngredientsObject($recipe)
        );
    }
}
