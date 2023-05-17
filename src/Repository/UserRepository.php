<?php

namespace App\Repository;

use App\Entity\User;
use App\Repository\Trait\RemoveTrait;
use App\Repository\Trait\SaveTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

class UserRepository extends ServiceEntityRepository implements RepositoryInterface
{
    use SaveTrait;
    use RemoveTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getEntityInstance(): User
    {
        return new User();
    }

    // public function createBulk(array $users): void
    // {
    //     try {
    //         $this->getEntityManager()->beginTransaction();

    //         foreach ($users as $user) {
    //             $this->getEntityManager()->persist($user);
    //         }
    //         $this->getEntityManager()->flush();
    //         $this->getEntityManager()->commit();
    //     } catch (Exception $e) {
    //         $this->getEntityManager()->rollback();
    //         throw $e;
    //     }
    // }
}
