<?php

namespace App\DataFixtures;

use App\Entity\RelationType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class RelationTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for($i = 0; $i < 10; $i++){
            $relationType = new RelationType();
            $relationType->setName($faker->name);

            $manager->persist($relationType);
        }

        $manager->flush();
    }
}
