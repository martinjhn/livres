<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UtilisateurFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        // Création Utilisateur
        // ********************
        for ($u = 1; $u <= 20; $u++) {
            $utilisateur = new Utilisateur();
            $utilisateur->setNom($faker->lastName())
                ->setPrenom($faker->firstName())
                ->setAdresse($faker->address())
                ->setTel($faker->e164PhoneNumber())
                ->setCourriel($faker->email())
                ->setMotDePasse($faker->password())
                ->setConfirm($faker->password());
            $manager->persist($utilisateur);
        }

        $manager->flush();
    }
}
