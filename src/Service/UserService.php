<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Collection\Users;
use App\Entity\User;
use App\Repository\UserRepository;
use App\DTO\UserDTO;
use App\DTO\RequestParams\UserParams;
use App\Query\UserInterface;
use App\Exception\NotFound\UserNotFoundException;

class UserService
{
    public function __construct(
        private UserRepository $repository,
        private readonly UserInterface $userQuery
    ) {
    }

    public function get(): ?Users
    {
        return $this->userQuery->getAll();
    }

    public function getByID(int $id): ?UserDTO
    {
        $user = $this->userQuery->getById($id);

        if (null === $user) {
            throw new UserNotFoundException($id);
        }

        return $user;
    }

    public function create(UserParams $params): int
    {
        $user = $this->repository->getEntityInstance();
        $user->update($params);
        $this->repository->save($user);

        return $user->getId();
    }

    public function delete(int $id): void
    {
        $user = $this->findUser($id);
        $this->repository->remove($user);
    }

    private function findUser(int $id): User
    {
        $user = $this->repository->find($id);

        if (null === $user) {
            throw new UserNotFoundException($id);
        }

        return $user;
    }

    public function update(int $id, UserParams $params): void
    {
        $user = $this->findUser($id);
        $user->update($params);
        $this->repository->save($user);
    }
}
