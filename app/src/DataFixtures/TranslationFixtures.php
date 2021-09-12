<?php

namespace App\DataFixtures;

use App\Entity\Key;
use App\Entity\Language;
use App\Entity\Translation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TranslationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $translation = new Translation();
        $translation->setTextValue('Bonjour le monde');

        $translation->setLanguage($this->getReference(Language::class.'_fra'));
        $translation->setKeyValue($this->getReference(Key::class.'_key'));

        $manager->persist($translation);

        $translation = new Translation();
        $translation->setTextValue('Hello world');

        $translation->setLanguage($this->getReference(Language::class.'_eng'));
        $translation->setKeyValue($this->getReference(Key::class.'_key'));
        $manager->persist($translation);

        $translation = new Translation();
        $translation->setTextValue('Hallo Welt');
        $translation->setLanguage($this->getReference(Language::class.'_deu'));
        $translation->setKeyValue($this->getReference(Key::class.'_key'));

        $manager->persist($translation);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            LanguageFixtures::class,
            KeyFixtures::class,
        ];
    }
}
