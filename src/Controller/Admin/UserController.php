<?php

namespace App\Controller\Admin;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin')]
class UserController extends AbstractController
{
    public function __construct(
        readonly private ArticleRepository $articleRepository,
        readonly private SluggerInterface $sluggerInterface
    )
    {
    
    }

    #[Route('/', name:'admin.index.form')]
    public function userForm():Response
    {
        return $this->render('admin/user/index.html.twig', [
            "articlesAllFigurines" => $this->articleRepository->getDataFigurines()->getResult(),

            "articlesDB" => $this-> articleRepository->getDataArticleDB()->getResult()
        ]);
    }

}