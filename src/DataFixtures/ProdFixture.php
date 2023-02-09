<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Produit;
use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProdFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker =Factory::create('fr_FR');
        for ($c=0;$c<3;$c++){
            $category = new Categorie();
            $category->setNom($faker->word());
            $category->setDescription($faker->text());
            $manager->persist($category);

            for ($i=0;$i<mt_rand(1,10);$i++){
                $produit = new Produit();
                $produit->setNom($faker->word(2,true));
                $produit->setDescription($faker->text());
                $produit->setPrix($faker->randomFloat(1,20));
                $produit->setPicture("https://loremflickr.com/320/240/paris");
                $produit->setCategorie($category);
                
                $manager->persist($produit);
            }
        }
        $manager->flush();
    }
}
