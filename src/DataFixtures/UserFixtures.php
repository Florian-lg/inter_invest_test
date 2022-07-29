<?php

namespace App\DataFixtures;

use App\Entity\LegalStatus;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user
            ->setEmail('admin@fakemail.com')
            ->setPassword('jesuisvotrehomme')
            ->setRoles(["ROLE_ADMIN"])
        ;

        $manager->persist($user);
        $manager->flush();
    }
}