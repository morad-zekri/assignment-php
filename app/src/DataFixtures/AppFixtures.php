<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordHasherInterface
     */
    private $encoder;

    /**
     * AppFixtures constructor.
     */
    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $this->addAdmin($manager);
        $this->addUser($manager);
        $manager->flush();
    }

    private function encodePassword(User $user, string $password): void
    {
        $plainPassword = $password;
        $encoded = $this->encoder->hashPassword($user, $plainPassword);

        $user->setPassword($encoded);
    }

    private function addAdmin(ObjectManager $manager): void
    {
        $user = new User();
        $this->encodePassword($user, 'admin');
        $user->setUsername('admin');
        $user->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $manager->persist($user);
    }

    private function addUser(ObjectManager $manager): void
    {
        $user = new User();
        $this->encodePassword($user, 'user');
        $user->setUsername('user');
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);
    }
}
