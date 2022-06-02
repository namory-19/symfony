<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    private $userPasswordHasherInterface;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('namory');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword(
            $this->userPasswordHasherInterface->hashPassword(
                $user, "nico19"
            )
        );
        $manager->persist($user);
        $manager->flush();

        $user = new User();
        $user->setUsername('syndicaliste');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword(
            $this->userPasswordHasherInterface->hashPassword(
                $user, "vill12"
            )
        );
        $manager->persist($user);
        $manager->flush();
    }
}
