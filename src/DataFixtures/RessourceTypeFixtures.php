<?php

namespace App\DataFixtures;

use App\Entity\RessourceType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
class RessourceTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 7; $i++){
            $ressourceType = new RessourceType();
            $ressourceType->setName($faker->jobTitle());

            $manager->persist($ressourceType);
        }

        $manager->flush();
    }
}
