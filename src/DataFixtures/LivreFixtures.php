<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Livre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LivreFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        // Création Catégorie
        // ******************
        for ($c = 1; $c <= 10; $c++) {
            $category = new Categorie();
            $category->setNom($faker->word());
            $manager->persist($category);

            // Création Livres
            // ***************
            // for ($l = 1; $l <= 20; $l++) {
            //     $book = new Livre();
            //     $book->
            //         ->setTitre($faker->word())
            //         ->setAuteur($faker->word())
            //         ->setAnnee($faker->year($max = 'now'));
            //     $manager->persist($book);
            // }
        }

        $manager->flush();
    }
}
