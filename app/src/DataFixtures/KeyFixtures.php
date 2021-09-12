<?php

namespace App\DataFixtures;

use App\Entity\Key;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class KeyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $key = new Key();
        $key->setName('app.title');
        $this->addReference(Key::class.'_key', $key);
        $manager->persist($key);
        $manager->flush();
    }
}
