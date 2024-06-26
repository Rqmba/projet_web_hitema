<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\OrdersDetails;
use App\Repository\ArticleRepository;
use App\Repository\MangaRepository;
use App\Repository\OrdersDetailsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


class ProductController extends AbstractController
{
    public function __construct(
        readonly private ArticleRepository $articleRepository,
        readonly private MangaRepository $mangaRepository,
        readonly private OrdersDetailsRepository $ordersDetailsRepository,
        readonly private EntityManagerInterface $entityManagerInterface,
    ) 
    {
    
    }

    // #[Route('/product/{slug}', name: 'manga.show', methods: ['GET'])]
    // public function showManga(string $slug): Response
    // {

    //     return $this->render('product/showOneMangaByProduct.html.twig', [
    //         'mangas' => $this->mangaRepository->getOneMangaByClick($slug)->getResult()
    //     ]);
    // }

    #[Route('/product', name: 'product.index', methods: ['GET'] )]
    public function productIndex():Response
    {
        return $this->render('product/index.html.twig', [
            "allArticles" => $this->articleRepository->getDataAllArticles()->getResult(),
            "Mangas" => $this->mangaRepository->getDataAllManga()->getResult(),
        ]);
    }

    #[Route('product/figurines', name: 'product.figurines', methods: ['GET'])]
    public function productFigurines():Response
    {
        return $this->render('product/Figurines.html.twig', [
            "Figurines" => $this->articleRepository->getDataFigurines()->getResult(),
            "Mangas" => $this->mangaRepository->getDataAllManga()->getResult(),
        ]);
    }

    #[Route('product/goodies', name: 'product.goodies', methods: ['GET'])]
    public function productGoodies():Response
    {
        return $this->render('product/Goodies.html.twig', [
            "Goodies" => $this->articleRepository->getDataGoodies()->getResult(),
            "Mangas" => $this->mangaRepository->getDataAllManga()->getResult(),
        ]);
    }

    #[Route('product/vetements', name:'product.vetements', methods: ['GET'])]
    public function productVetements():Response
    {
        return $this->render('product/Vetements.html.twig', [
            "Vetements" => $this->articleRepository->getDataVetements()->getResult(),
            "Mangas" => $this->mangaRepository->getDataAllManga()->getResult(),
        ]);
    }

    #[Route('/product/{slug}', name: 'product.show', methods: ['GET'])]
    public function showProduct(string $slug): Response
    {

        return $this->render('product/showOneProduct.html.twig', [
            'articles' => $this->articleRepository->getOneArticleByClick($slug)->getResult(),
            // 'articles' => $this->articleRepository->findBy(['slug']),
        ]);
    }

    #[Route('/product/{name}', name: 'manga.show', methods: ['GET'])]
    public function showManga(string $name): Response
    {

        return $this->render('product/showOneMangaByProduct.html.twig', [

            'articles' => $this->articleRepository->findBy(['title']),
            'mangas' => $this->mangaRepository->findBy(['name']),
            'name' => $name,
        ]);
    }

    #[Route('/product/user/{slug}', name:'productShip.show', methods:['GET'])]
    public function showProductShip(string $slug): Response
    {
        return $this->render('product/showProductShip.html.twig', [
            'articles' => $this->articleRepository->findBy(['slug' => $slug]),
        ]);
    }
}