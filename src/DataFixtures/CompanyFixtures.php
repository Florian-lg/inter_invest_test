<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\CompanyArchive;
use App\Entity\Site;
use App\Repository\LegalStatusRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CompanyFixtures extends Fixture implements DependentFixtureInterface
{
    private LegalStatusRepository $legalStatusRepository;
    private string $nbCompaniesToCreate;

    public function __construct(LegalStatusRepository $legalStatusRepository, int $nbCompaniesToCreate)
    {
        $this->legalStatusRepository = $legalStatusRepository;
        $this->nbCompaniesToCreate = $nbCompaniesToCreate;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($index = 0; $index < $this->nbCompaniesToCreate; $index++) {
            $site = new Site();

            $site
                ->setName($faker->company())
                ->setCity($faker->city())
                ->setZipcode($faker->postcode())
                ->setAddress($faker->streetAddress())
                ->setCountry($faker->country())
            ;

            $company = new Company();

            $companyArchive = new CompanyArchive();

            $companyArchive
                ->setName($faker->company())
                ->setLegalStatus($this->legalStatusRepository->findOneBy(["name" => "Société créée de fait"]))
                ->setSiren($faker->siren())
                ->setRegistrationCity($faker->city())
                ->setRegistrationDate($faker->dateTimeBetween('-10 months'))
                ->addSite($site)
                ->setCompany($company)
            ;

            $manager->persist($company);
            $manager->persist($companyArchive);
        }

        $manager->flush();
    }

    public function getDependencies(): ?array
    {
        return [
            LegalStatusFixtures::class
        ];
    }
}