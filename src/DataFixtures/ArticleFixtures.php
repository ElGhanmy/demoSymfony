<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=1;$i<=9;$i++)
        {
          $article= new Article();
          $article->setTitle("Titre de l'article $i")
                  ->setContent("<p>contenu de l'article $i</p>")
                  ->setImage("http://placehold.it/350x150")
                  ->setCreatedAt(new \DateTime());
          $manager->persist($article);        
        }

        $manager->flush();
    }
}
