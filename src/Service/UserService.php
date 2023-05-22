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
use App\DTO\RequestParams\UserByEmailParams;

class UserService
{
    public function __construct(
        private UserRepository $repository,
        private readonly UserInterface $userQuery
    ) {
    }

    public function getAll(): ?Users
    {
        return $this->userQuery->getAll();
    }

    public function get(string $guid): ?UserDTO
    {
        $user = $this->userQuery->get($guid);

        if (null === $user) {
            throw new UserNotFoundException($guid);
        }

        return $user;
    }

    public function create(UserParams $params): string
    {
        $user = $this->repository->getEntityInstance();
        $user->update($params);
        $this->repository->save($user);

        return $user->getGuid();
    }

    public function delete(string $guid): void
    {
        $user = $this->findUser($guid);
        $this->repository->remove($user);
    }

    private function findUser(string $guid): User
    {
        $user = $this->repository->find($guid);

        if (null === $user) {
            throw new UserNotFoundException($guid);
        }

        return $user;
    }

    public function update(string $guid, UserParams $params): void
    {
        $user = $this->findUser($guid);
        $user->update($params);
        $this->repository->save($user);
    }

    public function getByEmail(UserByEmailParams $params): UserDTO
    {
        $user = $this->userQuery->getByEmail($params->email);

        if (null === $user) {
            throw new UserNotFoundException($params->email);
        }

        return $user;
    }
}
