<?php

namespace App\DataFixtures;

use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LanguageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->addFrench($manager);
        $this->addEnglish($manager);
        $this->addGermany($manager);

        $manager->flush();
    }

    private function addFrench(ObjectManager $manager): void
    {
        $languageFra = new Language();
        $languageFra->setName('French');
        $languageFra->setIso('FRA');
        $languageFra->setLtr(true);
        $this->addReference(Language::class.'_fra', $languageFra);
        $manager->persist($languageFra);
    }

    private function addEnglish(ObjectManager $manager): void
    {
        $languageEng = new Language();
        $languageEng->setName('English');
        $languageEng->setIso('ENG');
        $languageEng->setLtr(true);
        $this->addReference(Language::class.'_eng', $languageEng);
        $manager->persist($languageEng);
    }

    private function addGermany(ObjectManager $manager): void
    {
        $languageDeu = new Language();
        $languageDeu->setName('Germany');
        $languageDeu->setIso('DEU');
        $languageDeu->setLtr(true);
        $this->addReference(Language::class.'_deu', $languageDeu);
        $manager->persist($languageDeu);
    }
}
