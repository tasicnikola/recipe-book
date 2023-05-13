<?php

namespace App\Service;

use App\Exception\CustomException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\Filesystem\Filesystem;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use App\Entity\Role;
use App\Repository\UserRepository;
use Exception;
use App\DTO\UserDTO;
use App\DTO\Parameters;

class UserService implements
    RetrieveInterface,
    CreateInterface,
    DeleteInterface,
    UpdateInterface
{
public function __construct(
    private ManagerRegistry $doctrine,
    private UserRepository $repository
    )
    {}
    
    public function get(): ?array
    {
        return $this->repository->getAll();
    }

    public function getByID(int $id): ?UserDTO
    {
        return $this->repository->get($id);
    }

    public function create(Parameters $userDto): int
    {
        $user = new User();

        return $this->repository->save($this->setUser($user, $userDto));
    }

    public function delete($id): void
    {
        $this->repository->delete($id);
    }

    public function update(int $id, Parameters $userDto): void
    {
        $user = $this->repository->find($id);

        $this->repository->update($this->setUser($user, $userDto));
    }

    private function setUser(User $user, Parameters $userDto): User
    {
        $user->setUsername($userDto->username)
            ->setPassword($userDto->password)
            ->setName($userDto->name)
            ->setSurname($userDto->surname)
            ->setEmail($userDto->email)
            ->setRole($this->doctrine->getManager()->getRepository(Role::class)->find($userDto->role));

        return $user;
    }
}
