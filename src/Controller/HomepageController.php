<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class HomepageController extends AbstractController
{

    public function __construct(
        readonly private ArticleRepository $articleRepository,
        readonly private SluggerInterface $sluggerInterface,
        readonly private EntityManagerInterface $entityManager,
    )
    {
    
    }




    #[Route('/', name: 'homepage.index', methods: ['GET'])]
    public function index():Response
    {
        // $entity = new Article();
        // $entity 
        // ->setTitle('test de larticle')
        // ->setSlug('test de larticle')
        // ->setPicture("pictur.jpg")
        // ->setDescription("Article test")
        // ->setPrice(2)
        // ->setQuantityinStock(3)
        // ->setReleaseDate(new DateTimeImmutable('2000-01-01'))
        // ->setStatut(true)
        // ->setManga()
        // ->setCategory()
        // ;

        // $this->entityManager->persist($entity);
        // $this->entityManager->flush();
        // dd($this->articleRepository->getDataAllArticles()->getResult());

        return $this->render('homepage/index.html.twig', [
            "articlesAllFigurines" => $this->articleRepository->getDataFigurines()->getResult(),

            "articlesDB" => $this-> articleRepository->getDataArticleDB()->getResult()
        ]);
    }

    #[Route('/', name:'admin.homepage.index', methods:['GET'])]
    public function adminIndex():Response
    {
        return $this->render('admin/homepage/index.html.twig');
    }
}