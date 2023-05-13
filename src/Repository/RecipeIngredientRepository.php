<?php

namespace App\Repository;

use App\Entity\RecipeIngredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecipeIngredient>
 *
 * @method RecipeIngredient|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecipeIngredient|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecipeIngredient[]    findAll()
 * @method RecipeIngredient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeIngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipeIngredient::class);
    }

    public function save(RecipeIngredient $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(RecipeIngredient $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function delete(int $id): void
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->delete(RecipeIngredient::class, 'ri')
            ->where('ri.recipe = :id')
            ->setParameter('id', $id);
        $query = $queryBuilder->getQuery();
        $query->execute();
    }
}
