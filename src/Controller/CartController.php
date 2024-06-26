<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\OrdersDetails;
use App\Repository\ArticleRepository;
use App\Repository\OrdersDetailsRepository;
use App\Repository\OrdersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CartController extends AbstractController
{
    public function __construct(
        readonly private ArticleRepository $articleRepository,
        readonly private OrdersRepository $ordersRepository,
        readonly private OrdersDetailsRepository $ordersDetailsRepository,
        readonly private EntityManagerInterface $entityManager
    ) 
    {
    }
    #[IsGranted('ROLE_USER')]
    #[Route('/add-to-cart/{id}', name: 'cart.index', methods: ['GET'])]
    public function addToCart(int $id): Response
    {
        $article = $this->articleRepository->find($id);

        $user = $this->getUser();

        // if (!$user) {
        //     return $this->redirectToRoute('security.login');
        // }
    
        $order = $this->ordersRepository->findOneBy(['User' => $user, 'statut' => 'open']);

        if (!$order) {
            $order = (new Orders())
                ->setUser($user)
                ->setReceiptDate(new \DateTime())
                ->setTotalQty(0)
                ->setTotalPrice(0)
                ->setStatut('open');

            $this->entityManager->persist($order);
        }

        $orderDetail = (new OrdersDetails())
            ->setOrders($order)
            ->setArticle($article)
            ->setQty(1)
            ->setPrice($article->getPrice());

        $order->setTotalQty($order->getTotalQty() + 1);
        $order->setTotalPrice($order->getTotalPrice() + $article->getPrice());

        $this->entityManager->persist($orderDetail);
        $this->entityManager->flush();

        $notice = 'Article ajouté avec succès !';
        $this->addFlash('notice', $notice);

        return $this->redirectToRoute('admin.shipUser.form');





    }

    #[Route('/user/ship/{id}', name: 'admin.shipUser.remove', methods: ['GET'])]
    public function removeArticle(?int $id): Response
    {
        $orderDetail = $this->ordersDetailsRepository->find($id);

        if ($orderDetail) {
            $order = $orderDetail->getOrders();
            $order->setTotalQty($order->getTotalQty() - $orderDetail->getQty());
            $order->setTotalPrice($order->getTotalPrice() - $orderDetail->getPrice());

            $this->entityManager->remove($orderDetail);

            if ($order->getTotalQty() <= 0) {
                $this->entityManager->remove($order);
            }
        


        $this->entityManager->flush();

        $notice = 'Article supprimé avec succès !';
        $this->addFlash('notice', $notice);

        return $this->redirectToRoute('admin.shipUser.form');
    }
    }
}
