<?php

namespace App\Entity;

use App\DTO\RequestParams\UserParams;
use App\Entity\Trait\TimestampableTrait;
use App\Entity\Trait\HasGuidTrait;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
#[ORM\HasLifecycleCallbacks]
class User implements JsonSerializable, BaseEntityInterface
{
    use TimestampableTrait;
    use HasGuidTrait;

    #[ORM\Column(length: 64, unique: true)]
    private string $username;

    #[ORM\Column(length: 64)]
    private string $password;

    #[ORM\Column(length: 64)]
    private ?string $name = null;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $surname = null;

    #[ORM\Column(length: 64, unique: true)]
    private string $email;

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function update(UserParams $params)
    {
        $this->name = $params->name;
        $this->surname = $params->surname;
        $this->email = $params->email;
        $this->username = $params->username;
        $this->password = $params->password;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'guid'       => $this->guid,
            'name'       => $this->name,
            'lastName'   => $this->surname,
            'email'      => $this->email,
            'role'       => $this->username,
            'team'       => $this->password,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
