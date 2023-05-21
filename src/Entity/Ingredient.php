<?php

namespace App\Entity;

use App\DTO\RequestParams\IngredientParams;
use App\Entity\Trait\TimestampableTrait;
use App\Entity\Trait\HasGuidTrait;
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
    use HasGuidTrait;

    #[ORM\Column(length: 64, unique: true)]
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function update(IngredientParams $params): void
    {
        $this->name = $params->name;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'guid'       => $this->guid,
            'name'       => $this->name,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
