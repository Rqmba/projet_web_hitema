<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\ArticleRepository;
use App\Repository\MangaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    public function __construct(
        readonly private ArticleRepository $articleRepository,
        readonly private MangaRepository $mangaRepository,
        ) 
        {
        }
    
    #[Route('/search', name:'search.index')]
    public function searchIndex(Request $request): Response
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        $article = [];

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form);
            $query = $form->get('query')->getData();
            $article = $this->articleRepository->findArticleBySearch($query);

        }

        return $this->render('form/searchIndex.html.twig', [
            'searchForm' => $form->createView(),
            'article' => $article,
        ]);
       
    }

}