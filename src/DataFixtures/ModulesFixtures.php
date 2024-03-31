<?php

namespace App\DataFixtures;

use App\Entity\Module;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class ModulesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = \Faker\Factory::create('fr_FR');
        for ($i=0; $i < 100; $i++) {
            $modules = new Module();
           $modules->setNomModule($faker->domainName);
           $modules->setNbHeure($faker->numberBetween(10, 100));
           $manager->persist($modules);
        }
        $manager->flush();
    }
}
