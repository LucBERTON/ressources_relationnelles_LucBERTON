<?php

namespace App\DataFixtures;

use App\Entity\RessourceCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class RessourceCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $ressourceCategory = new RessourceCategory();
            $ressourceCategory->setName($faker->jobTitle);

            $manager->persist($ressourceCategory);
        }

        $manager->flush();
    }
}
