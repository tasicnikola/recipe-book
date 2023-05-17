<?php

namespace App\Entity;

use App\DTO\RequestParams\IngredientParams;
use App\Entity\Trait\TimestampableTrait;
use App\Repository\IngredientRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use JsonSerializable;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
#[ORM\Table(name: 'ingredients')]
#[HasLifecycleCallbacks]
class Ingredient implements JsonSerializable, BaseEntityInterface
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 50)]
    private string $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    
    public function update(IngredientParams $params)
    {
        $this->name = $params->name;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
