<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user
            ->setEmail('admin@fakemail.com')
            ->setPassword($this->hasher->hashPassword($user, 'admin'))
            ->setRoles(["ROLE_ADMIN"])
        ;

        $manager->persist($user);
        $manager->flush();
    }
}