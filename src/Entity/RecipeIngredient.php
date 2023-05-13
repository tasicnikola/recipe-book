<?php

namespace App\Entity;

use App\Repository\RecipeIngredientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeIngredientRepository::class)]
class RecipeIngredient
{
    #[ORM\Id, ORM\ManyToOne(targetEntity:"App\Entity\Recipe", inversedBy:"recipeIngredient")]
    #[ORM\JoinColumn(nullable:false)]
    private Recipe $recipe;

    #[ORM\Id, ORM\ManyToOne(targetEntity:"App\Entity\Ingredient", inversedBy:"recipeIngredient")]
    #[ORM\JoinColumn(nullable:false)]
    private Ingredient $ingredient;

    #[ORM\Column(length: 20)]
    private ?string $amount = null;

    public function getRecipe(): Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(Recipe $recipe): self
    {
        $this->recipe = $recipe;

        return $this;
    }

    public function getIngredient(): Ingredient
    {
        return $this->ingredient;
    }

    public function setIngredient(Ingredient $ingredient): self
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}
