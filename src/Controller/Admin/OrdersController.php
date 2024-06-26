<?php

namespace App\Controller\Admin;

use App\Repository\OrdersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_SUPER_ADMIN')]
#[Route('admin/orders')]

class OrdersController extends AbstractController
{
    private Request $request;

    public function __construct(
        private RequestStack $requestStack,
        private OrdersRepository $ordersRepository,
    ) {
        $this->request = $requestStack->getCurrentRequest();
    }

    #[Route('/list', name:'admin.orders.list')]
    public function ordersList(): Response
    {
        return $this->render('admin/orders/ordersList.html.twig', [
            'orders' => $this->ordersRepository->findAll(),
        ]);
        
    }
}