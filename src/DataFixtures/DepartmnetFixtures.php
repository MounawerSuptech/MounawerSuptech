<?php

namespace App\DataFixtures;

use App\Entity\Department;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class DepartmnetFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = \Faker\Factory::create('fr_FR');
        for ($i=0; $i < 10; $i++) {
            $departement = new Department();
           $departement->setNomDepartment($faker->domainWord);
           $manager->persist($departement);
        }

        $manager->flush();
    }
}
