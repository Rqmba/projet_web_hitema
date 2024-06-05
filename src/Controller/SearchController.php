<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    // public function __construct(
    //     readonly private ArticleRepository $articleRepository,
    // ) 
    // {

    // }
    #[Route('/search', name:'search.index')]
    public function search(Request $request, ArticleRepository $articleRepository): JsonResponse
    {
        $query = $request->query->get('query', '');

        if ($query) { 
            $article = $articleRepository->findArticleBySearch($query);
        } else {
           $article = [];
        }

        $data = [];

        foreach ($article as $articles) 
        {
            $data[] = [
                'title' => $articles->getTitle(),
                'slug' => $articles->getSlug(),
                'description' => $articles->getDescription(),
                'picture' => $articles->getPicture(),
                'categoryName' => $articles->getCategory()->getName(),
                'price' => $articles->getPrice(),

            ];
        }
        return new JsonResponse($data);
    }

    
}