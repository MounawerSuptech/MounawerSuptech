<?php

namespace App\DataFixtures;

use App\Entity\Department;
use App\Repository\DepartmentRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class ClasseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $department = $manager->getRepository(Department::class)->findAll();
        // $product = new Product();
        // $manager->persist($product);
        $faker = \Faker\Factory::create('fr_FR');
        for ($i=0; $i < 100; $i++) {
            $classe = new \App\Entity\Classe();
            $string1 = $faker->randomElement(['ARCTIC','INFO','MATH','GENIE LOGICIEL','DATASCIENCE']);
            $string2 = $faker->numberBetween(1,50);
            $string3= "classe_".$string1."_".$string2;
           $classe->setNomClasse($string3);
           $classe->setDepartment($department[array_rand($department)]  );
           $manager->persist($classe);

        }

        $manager->flush();
    }
}
