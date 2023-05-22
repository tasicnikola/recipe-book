<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const USER_NAMES = ["Denzel", "Bradley", "Jason", "Leonardo", "Adam"];
    public const USER_SURNAMES = ["Washington", "Cooper", "Statham", "DiCaprio", "Sandler"];

    public function load(ObjectManager $manager): void
    {
        $usersManager =  $this->createUser(0);
        $manager->persist($usersManager);
        $manager->flush();

        for ($i = 1; $i < count(self::USER_NAMES); $i++) {
            $user = $this->createUser($i);

            $manager->persist($user);
        }
        $manager->flush();
    }

    private function createUser(int $index): User
    {
        $user = new User();
        $user->setName(self::USER_NAMES[$index])
            ->setSurname(self::USER_SURNAMES[$index])
            ->setEmail(strtolower($user->getName()[0] . $user->getSurname()) . $index . "@gmail.com")
            ->setPassword('pass_' . $index)
            ->setUsername(self::USER_NAMES[$index] . self::USER_SURNAMES[$index]);
        $this->setReference($user->getName(), $user);

        return $user;
    }
}
