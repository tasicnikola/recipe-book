<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Doctrine\Query;

use App\DTO\Collection\Users;
use App\DTO\UserDTO;
use App\Query\UserInterface;
use DateTime;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;

class User implements UserInterface
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    public function getAll(): Users
    {
        $usersData = $this->connection->createQueryBuilder('users')
            ->select(
                'id',
                'name',
                'surname',
                'email',
                'username',
                'password',
                'created_at',
                'updated_at'
            )
            ->from('users')
            ->orderBy('name', 'ASC')
            ->fetchAllAssociative();

        return new Users(array_map(fn (array $userData) => $this->createDTO($userData), $usersData));
    }

    public function getById(int $id): ?UserDTO
    {
        $userData = $this->connection->createQueryBuilder()
        ->select(
            'id',
            'name',
            'surname',
            'email',
            'username',
            'password',
            'created_at',
            'updated_at'
        )
        ->from('users')
            ->where('id = ?')
            ->setParameter(0, $id)
            ->fetchAssociative();

        if (false === $userData) {
            return null;
        }

        return $this->createDTO($userData);
    }

    private function createDTO(array $userData): UserDTO
    {
        return new UserDTO(
            $userData['id'],
            $userData['name'],
            $userData['surname'],
            $userData['email'],
            $userData['username'],
            $userData['password'],
            new DateTimeImmutable($userData['created_at']),
            $userData['updated_at'] ? new DateTime($userData['updated_at']) : null,
        );
    }
}
