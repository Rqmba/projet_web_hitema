<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    // public const int TOTAL_CREATED = 3;

    public function load(ObjectManager $manager): void
    {
    //     for ($i=0; $i < self::TOTAL_CREATED; $i++) { 
    //         $entity = new Article();

    //         $entity
    //         ->setTitle("Article $i")
    //         ->setPicture("picture $i.jpg")
    //         ->setDescription("Article $i")
    //         ->setPrice($i)
    //         ->setQuantityinStock($i)
    //         ;

    //         $manager->persist($entity);
    //     }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
