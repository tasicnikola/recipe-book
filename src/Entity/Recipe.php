<?php

namespace App\Entity;

use App\DTO\RequestParams\RecipeParams;
use App\Entity\Trait\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
#[ORM\Table(name: 'recipes')]
#[ORM\HasLifecycleCallbacks]
class Recipe implements JsonSerializable, BaseEntityInterface
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 100)]
    private string $title;

    #[ORM\Column(length: 255)]
    private string $imageUrl;

    #[ORM\Column(type: Types::TEXT)]
    private string $description;

    #[ORM\ManyToOne(targetEntity: "App\Entity\User")]
    #[ORM\JoinColumn(name: 'user', referencedColumnName: 'id')]
    private User $user;

    #[ORM\ManyToMany(targetEntity: Ingredient::class, mappedBy: 'recipe', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\JoinTable(name: 'recipe_ingredient')]
    private Collection $ingredients;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection([]);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function setIngredients(ArrayCollection $ingredients): self
    {
        $this->ingredients  = $ingredients;

        return $this;
    }

    public function addIngredient(Ingredient $ingredient): void
    {
        $this->ingredients->add($ingredient);
    }

    public function removeIngredient(Ingredient $ingredient): void
    {
        $this->ingredients->removeElement($ingredient);
    }

    public function syncIngredients(array $ingredients): void
    {
        foreach ($this->ingredients->toArray() as $ingredient) {
            if (!in_array($ingredient->getName(), $ingredients)) {
                $this->removeIngredient($ingredient);
            }
        }
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image_url' => $this->imageUrl,
            'description' => $this->description,
            'user' => $this->user,
            'ingredients' => $this->ingredients,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    public function update(RecipeParams $params, User $user): void
    {
        $this->title = $params->title;
        $this->imageUrl = $params->image;
        $this->description = $params->description;
        $this->user = $user;
    }
}
