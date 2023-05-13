<?php

namespace App\Repository;

use App\Entity\Ingredient;
use App\DTO\IngredientDTO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Ingredient>
 *
 * @method Ingredient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ingredient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ingredient[]    findAll()
 * @method Ingredient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ingredient::class);
    }

    public function save(Ingredient $entity): int
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity->getId();
    }

    public function update(Ingredient $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function getAll(): ?array
    {
        $query = $this->selectIngredients();

        return $query
            ->getQuery()
            ->getArrayResult();
    }

    public function get(int $id): ?IngredientDTO
    {
        $query = $this->selectIngredients()
            ->where('i.id = :id')
            ->setParameter('id', $id)
            ->getQuery();
        $ingredient = $query->getOneOrNullResult();

        if ($ingredient === null) {
            throw new Exception("Recipe with id: $id not found");
        }

        return $this->createDTO($ingredient);
    }

    public function delete(int $id): void
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->delete(Ingredient::class, 'i')
            ->where('i.id = :id')
            ->setParameter('id', $id);
        $query = $queryBuilder->getQuery();
        $query->execute();
    }

    private function selectIngredients(): QueryBuilder
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('i')
            ->from(Ingredient::class, 'i');
    }

    private function createDTO(Ingredient $ingredient): IngredientDTO
    {
        return new IngredientDTO(
            $ingredient->getName()
        );
    }
}
