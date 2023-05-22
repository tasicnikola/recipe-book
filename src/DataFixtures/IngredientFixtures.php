<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IngredientFixtures extends Fixture
{
    public const INGREDIENT_NAMES = ['Salt', 'Sugar', 'Water', 'Olive oil', 'Black peper', 'Paprika', 'Oregano'];

    public function load(ObjectManager $manager): void
    {
        foreach (self::INGREDIENT_NAMES as $name) {
            $team = new Ingredient();
            $team->setName($name);
            $manager->persist($team);
            $this->setReference($name, $team);
        }

        $manager->flush();
    }
}
