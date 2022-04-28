<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Citizen;
use App\Entity\Ressource;
use App\Entity\RelationType;
use App\Entity\RessourceCategory;
use App\DataFixtures\CitizenFixtures;
use App\Repository\CitizenRepository;
use Doctrine\Persistence\ObjectManager;
use App\Repository\RelationTypeRepository;
use App\Repository\RessourceTypeRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Repository\RessourceCategoryRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RessourceFixtures extends Fixture implements DependentFixtureInterface
{
    private RelationTypeRepository $relationTypeRepository;
    private RessourceCategoryRepository $ressourceCategoryRepository;
    private CitizenRepository $citizenRepository;
    private RessourceTypeRepository $ressourceTypeRepository;

    public function __construct(
        RelationTypeRepository $relationTypeRepository,
        RessourceCategoryRepository $ressourceCategoryRepository,
        CitizenRepository $citizenRepository,
        RessourceTypeRepository $ressourceTypeRepository
    )
    {

        $this->relationTypeRepository = $relationTypeRepository;
        $this->ressourceCategoryRepository = $ressourceCategoryRepository;
        $this->citizenRepository = $citizenRepository;
        $this->ressourceTypeRepository = $ressourceTypeRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 30; $i++) {
            $moderator = $this->getOneModeratorForDependancy($this->citizenRepository);
            $citizen = $this->getOneCitizenForDependancy($this->citizenRepository);
            $ressourceType = $this->getRessourceTypeForDependancy($this->ressourceTypeRepository);
            $relation = $this->getOneRelationTypeForDependancy($this->relationTypeRepository);
            $category = $this->getRessourceCategoryForDependancy($this->ressourceCategoryRepository);

            $ressource = new Ressource();

            $ressource->setAuthor($faker->name())
            ->setModerationStatus(1)
            ->setContent($faker->text)
            ->setTitle($faker->sentence())
            ->setCategory($category)
            ->setModerationDate(new \DateTimeImmutable())
            ->setModerator($moderator)
            ->setSearches($faker->numberBetween(1,5))
            ->setShares($faker->numberBetween(1,20))
            ->setStatus(true)
            ->setSubmitDate(new \DateTimeImmutable())
            ->setSubmitter($citizen)
            ->setType($ressourceType)
            ->setUrl($faker->url)
            ->setViews($faker->numerify);

            $manager->persist($ressource);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CitizenFixtures::class,
            RelationTypeFixtures::class,
            RessourceTypeFixtures::class,
            RessourceCategoryFixtures::class,
        ];
    }

    public function getOneCitizenForDependancy(CitizenRepository $citizenRepository): Citizen
    {
        $citizenArray = $citizenRepository->findAll();
        $citizen = array_rand($citizenArray, 1);


        return $citizenArray[$citizen];
    }

    public function getOneModeratorForDependancy(CitizenRepository $citizenRepository): Citizen
    {
        $moderatorArray = $citizenRepository->findAll();
        $moderator = array_rand($moderatorArray, 1);


        return $moderatorArray[$moderator];
    }

    public function getOneRelationTypeForDependancy(RelationTypeRepository $relationTypeRepository): RelationType
    {
        $relationArray = $relationTypeRepository->findAll();
        $relation = array_rand($relationArray, 1);

        return $relationArray[$relation];
    }

    public function getRessourceTypeForDependancy(RessourceTypeRepository $ressourceTypeRepository): \App\Entity\RessourceType
    {
        $ressourceTypeArray = $ressourceTypeRepository->findAll();
        $ressourceType = array_rand($ressourceTypeArray, 1);

        return $ressourceTypeArray[$ressourceType];
    }

    public function getRessourceCategoryForDependancy(RessourceCategoryRepository $ressourceCategoryRepository): RessourceCategory
    {
        $ressourceCatArray = $ressourceCategoryRepository->findAll();
        $ressourceCat = array_rand($ressourceCatArray);

        return $ressourceCatArray[$ressourceCat];
    }
}
