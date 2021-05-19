<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Emprunt;
use App\Entity\Livre;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        $listeUtilisateur = [];
        // Création Utilisateur
        // ********************
        for ($u = 1; $u <= 5; $u++) {
            $mdp = $faker->password();
            $utilisateur = new Utilisateur();
            $utilisateur->setNom($faker->lastName())
                ->setPrenom($faker->firstName())
                ->setAdresse($faker->address())
                ->setTel($faker->e164PhoneNumber())
                ->setCourriel($faker->email())
                ->setMotDePasse($mdp)
                ->setConfirm($mdp);
            $listeUtilisateur[] = $utilisateur;
            $manager->persist($utilisateur);
        }

        // Création Catégorie
        // ******************
        for ($c = 1; $c <= 5; $c++) {
            $category = new Categorie();
            $category->setNom($faker->word());
            $manager->persist($category);

            // Création Livres
            // ***************
            for ($l = 1; $l <= 5; $l++) {
                $livre = new Livre();
                $livre->setTitre($faker->word())
                    ->setAuteur($faker->word())
                    ->setAnnee($faker->year($max = 'now'))
                    ->setCategorie($category);
                $manager->persist($livre);

                // Création Emprunt
                // ****************
                for ($e = 1; $e <= 5; $e++) {
                    $currUser = $listeUtilisateur[array_rand($listeUtilisateur, 1)];
                    $emprunt = new Emprunt();

                    $emprunt->setLivre($livre)
                        ->setEmprunteur($currUser)
                        ->setDateEmprunt($faker->dateTimeBetween("-2 months"));
                    $nbJours = (new \DateTime())->diff($emprunt->getDateEmprunt())->days;
                    $emprunt
                        ->setDateRetour($faker->dateTimeBetween("-" . $nbJours . "days", "+" . $nbJours . "days"));
                    $manager->persist($emprunt);
                }
            }

            $manager->flush();
        }
    }
}
