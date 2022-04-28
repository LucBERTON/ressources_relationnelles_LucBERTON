<?php

namespace App\DataFixtures;

use App\Entity\Citizen;
use App\Entity\Comment;
use App\Entity\Ressource;
use App\Repository\CitizenRepository;
use App\Repository\RessourceRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    private CitizenRepository $citizenRepository;
    private RessourceRepository $ressourceRepository;

    public function __construct(CitizenRepository $citizenRepository, RessourceRepository $ressourceRepository)
    {
        $this->citizenRepository = $citizenRepository;
        $this->ressourceRepository = $ressourceRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 15; $i++) {
            $citizen = $this->getOneCitizenForDependancy($this->citizenRepository);
            $ressource = $this->getOneRessourceForDependancy($this->ressourceRepository);
            $comment = new Comment();

            $comment->setContent($faker->text)
                ->setRessource($ressource)
                ->setAuthor($citizen)
                ->setDate(new \DateTimeImmutable())
                ->setModerationStatus(1);

            $manager->persist($comment);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CitizenFixtures::class,
            RessourceFixtures::class
        ];
    }

    public function getOneCitizenForDependancy(CitizenRepository $citizenRepository): Citizen
    {
        // Test Github hook
        $citizenArray = $citizenRepository->findAll();
        $citizen = array_rand($citizenArray, 1);


        return $citizenArray[$citizen];
    }

    public function getOneRessourceForDependancy(RessourceRepository $ressourceRepository): Ressource
    {
        $ressourceArray = $ressourceRepository->findAll();
        $ressource = array_rand($ressourceArray, 1);


        return $ressourceArray[$ressource];
    }

}
