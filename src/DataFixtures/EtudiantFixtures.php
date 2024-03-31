<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use App\Entity\Etudiant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class EtudiantFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $classe = $manager->getRepository(Classe::class)->findAll();
        // $product = new Product();
        // $manager->persist($product);
        $faker = \Faker\Factory::create('fr_FR');
        for ($i=0; $i < 100; $i++) {
            $etudiant = new Etudiant();
            $etudiant->setNom($faker->lastName);
            $etudiant->setPrenom($faker->firstName);
            $etudiant->setAdresse($faker->address);
            $etudiant->setClasse($classe[array_rand($classe)]  );
            $manager->persist($etudiant);

        }
        $manager->flush();
    }
}
