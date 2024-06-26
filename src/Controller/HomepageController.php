<?php

namespace App\Controller;


use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomepageController extends AbstractController
{

    public function __construct(
        readonly private ArticleRepository $articleRepository,
    )
    {
    
    }

    #[Route('/', name: 'homepage.index', methods: ['GET'])]
    public function index():Response
    {

        return $this->render('homepage/index.html.twig', [
            "articlesAllFigurines" => $this->articleRepository->getDataFigurines()->getResult(),

            "articlesDB" => $this-> articleRepository->getDataArticleDB()->getResult()
        ]);
    }
}