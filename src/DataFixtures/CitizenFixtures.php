<?php

namespace App\DataFixtures;

use App\Entity\Citizen;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class CitizenFixtures extends Fixture
{

    /** @var UserPasswordHasherInterface */
    private $encoder;


    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $admin = new Citizen();
        $admin->setLastName('admin')
            ->setFirstName('admin')
            ->setPassword('testtest')
            ->setEmail('admin@admin.com')
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

        for ($i = 0; $i < 20; $i++) {
            $citizen = new Citizen();
            $citizen->setEmail($faker->email())
                ->setPassword($faker->password)
                ->setRoles(['ROLE_USER'])
                ->setStatus(true)
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setStreetName($faker->streetName())
                ->setStreetNumber($faker->numberBetween(1, 999))
                ->setPostalCode($faker->postcode())
                ->setCity($faker->city())
                ->setCountry($faker->country());

            $manager->persist($citizen);
        }


        //données pour user de test
        $citizen = new Citizen();
        $citizen->setEmail('citoyen@test.fr')
            ->setPassword($this->encoder->hashPassword($citizen, 'citoyen'))
            ->setRoles(['ROLE_USER'])
            ->setStatus(true)
            ->setFirstName('Citoyen')
            ->setLastName('DeTest')
            ->setStreetName($faker->streetName())
            ->setStreetNumber($faker->numberBetween(1, 999))
            ->setPostalCode($faker->postcode())
            ->setCity($faker->city())
            ->setCountry($faker->country());

        $manager->persist($citizen);

        //données pour moderator de test
        $moderator = new Citizen();
        $moderator->setEmail('moderateur@test.fr')
            ->setPassword($this->encoder->hashPassword($moderator, 'moderateur'))
            ->setRoles(['ROLE_USER', 'ROLE_MODERATOR'])
            ->setStatus(true)
            ->setFirstName('Moderateur')
            ->setLastName('DeTest')
            ->setStreetName($faker->streetName())
            ->setStreetNumber($faker->numberBetween(1, 999))
            ->setPostalCode($faker->postcode())
            ->setCity($faker->city())
            ->setCountry($faker->country());

        $manager->persist($moderator);

        //données pour admin de test
        $admin = new Citizen();
        $admin->setEmail('admin@test.fr')
            ->setPassword($this->encoder->hashPassword($admin, 'admin'))
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
            ->setStatus(true)
            ->setFirstName('Admin')
            ->setLastName('DeTest')
            ->setStreetName($faker->streetName())
            ->setStreetNumber($faker->numberBetween(1, 999))
            ->setPostalCode($faker->postcode())
            ->setCity($faker->city())
            ->setCountry($faker->country());

        $manager->persist($admin);


        //données pour superadmin de test
        $superadmin = new Citizen();
        $superadmin->setEmail('superadmin@test.fr')
            ->setPassword($this->encoder->hashPassword($superadmin, 'superadmin'))
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN', 'ROLE_SUPERADMIN'])
            ->setStatus(true)
            ->setFirstName('SuperAdmin')
            ->setLastName('DeTest')
            ->setStreetName($faker->streetName())
            ->setStreetNumber($faker->numberBetween(1, 999))
            ->setPostalCode($faker->postcode())
            ->setCity($faker->city())
            ->setCountry($faker->country());

        $manager->persist($superadmin);

        $manager->persist($admin);

        $manager->flush();
    }
}
