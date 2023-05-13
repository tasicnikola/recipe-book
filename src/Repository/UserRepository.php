<?php

namespace App\Repository;

use App\DTO\UserDTO;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Config\Definition\Exception\Exception;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity): int
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity->getId();
    }

    public function update(User $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function get(int $id): ?UserDTO
    {
        $query = $this->selectUsers()
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery();
        $user = $query->getOneOrNullResult();
        if ($user === null) {
            throw new Exception("Recipe with id: $id not found");
        }

        return $this->createDTO($user);
    }

    public function getAll(): array
    {
        $query = $this->selectUsers();

        return $query
            ->getQuery()
            ->getArrayResult();
    }

    public function delete(int $id): void
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->delete(User::class, 'u')
            ->where('u.id = :id')
            ->setParameter('id', $id);
        $query = $queryBuilder->getQuery();
        $query->execute();
    }

    private function selectUsers(): QueryBuilder
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u');
    }

    private function createDTO(User $user): UserDTO
    {
        return new UserDTO(
            $user->getUsername(),
            $user->getPassword(),
            $user->getName(),
            $user->getSurname(),
            $user->getEmail(),
            $user->getCreated()->format('date_format'),
            $user->getUpdated()->format('date_format'),
            $user->getRole()
        );
    }
}
