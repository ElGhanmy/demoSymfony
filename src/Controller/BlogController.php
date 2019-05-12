<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;



class BlogController extends AbstractController
{
            //liste des articles

    /**
     * @Route("/articles", name="blog")
     */
    public function index(ArticleRepository $repo )
    {
        
        $articles= $repo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles'=> $articles
        ]);
    }

    //page d'acceuil
    
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('blog/home.html.twig');
    }
     
    //créer un article

    /**
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blog_edit")
     */

    public function form(Request $request, ObjectManager $manager, Article $article=null)
    {
        if(!$article){
        $article= new Article();
    }
        $form = $this->createFormBuilder($article)
                     ->add('title', TextType::class)
                     ->add('content', TextareaType::class)
                     ->add('image', TextType::class)
                     ->add('createdAt', DateType::class)
                     ->add('save', SubmitType::class, ['label' => 'Créer un Article'])
                     ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
          $manager->persist($article);
          $manager->flush();
          return $this->redirectToRoute('blog_show', ['id'=> $article->getId()]);
        }

        return $this->render('blog/create.html.twig', [
            'formArticle'=> $form->createView()
        ]);
    }

    //page d'un seul article

    /**
     * @Route("/blog/{id}", name="blog_show")
     */

    public function show(Article $article)
    {
        return $this->render('blog/show.html.twig',
    [
        'article'=> $article
    ]);
    }

    
}
