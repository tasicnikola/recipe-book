<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Ingredient;
use Doctrine\Common\Collections\ArrayCollection;

class RecipeFixtures extends Fixture implements DependentFixtureInterface
{
    public const RECIPE_NAMES = [
        'Barbecue Pork and Penne Skillet',
        'Bean Burritos',
        'Citrus Coconut Steamed Cod',
        'Blue Plate Beef Patties',
        'Chicken Rice Bowl',
        'Loaded Mexican Pizza'
    ];

    public function load(ObjectManager $manager): void
    {
        foreach(self::RECIPE_NAMES as $name){
            $recipe = new Recipe();
            $recipe->setTitle($name);
            $recipe->setImageUrl('https://cdn.britannica.com/98/235798-050-3C3BA15D/Hamburger-and-french-fries-paper-box.jpg');
            $recipe->setDescription('Prepare ' .$name .  ' with these ingredients: ' . IngredientFixtures::INGREDIENT_NAMES[array_rand(IngredientFixtures::INGREDIENT_NAMES)]);
            $recipe->setUser($this->getReference(UserFixtures::USER_NAMES[array_rand(UserFixtures::USER_NAMES)]));
            
            $ingredients  = [];
            for($i=1;  $i<5; $i++) {
                $ingredient = new Ingredient();
                $ingredient->setName(IngredientFixtures::INGREDIENT_NAMES[array_rand(IngredientFixtures::INGREDIENT_NAMES)] . ' - ' .  rand(100, 500) . 'g');
                $ingredients[] = $ingredient;
            }

            $recipe->setIngredients(new ArrayCollection($ingredients));
            $manager->persist($recipe);
            $this->setReference($recipe->getTitle(), $recipe);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            IngredientFixtures::class,
            UserFixtures::class
        ];
    }
}