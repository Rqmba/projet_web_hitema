<?php

namespace App\Controller\Admin;

use App\Entity\OrdersDetails;
use App\Repository\ArticleRepository;
use App\Repository\OrdersDetailsRepository;
use App\Repository\OrdersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/admin')]
class AdminController extends AbstractController
{
    public function __construct(
        readonly private ArticleRepository $articleRepository,
        readonly private OrdersRepository $ordersRepository,
        readonly private OrdersDetailsRepository $ordersDetailsRepository,
    ) 
    
    {
        
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/homepage', name:'admin.index', methods:['GET'])]
    public function adminIndex():Response
    {
        return $this->render('admin/homepage/index.html.twig', [
            "articlesAllFigurines" => $this->articleRepository->getDataFigurines()->getResult(),

            "articlesDB" => $this-> articleRepository->getDataArticleDB()->getResult()
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/user', name:'admin.userAccount.form', methods:['GET'])]
    public function userAccount():Response
    {
        return $this->render('admin/user/userAccount.html.twig');
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/user/ship', name:'admin.shipUser.form', methods:['GET'])]
    public function shipUser():Response
    {   
        return $this->render('admin/user/shipUser.html.twig', [
            'orders' => $this->ordersRepository->findAll(),
            'ordersDetails' => $this->ordersDetailsRepository->findAll(),
            'articles' => $this->articleRepository->findAll(),
        ]);
    }

    // #[IsGranted('ROLE_USER')]
    // #[Route('/user/ship/{id}', name: 'admin.shipUser.remove')]
    // public function removeArticle(int $id):Response
    // {
    //     $order = $this->articleRepository->find($id);
    // }
}