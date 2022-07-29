<?php

namespace App\DataFixtures;

use App\Entity\LegalStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LegalStatusFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $handle = @fopen('assets/imports/legal_status.csv', 'rb');

        while (($row = fgetcsv($handle, 0, ';')) !== false) {
            $legalStatus = new LegalStatus();

            $legalStatus->setName($row[0]);

            $manager->persist($legalStatus);
        }

        $manager->flush();
    }
}