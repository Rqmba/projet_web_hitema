<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\ArticleRepository;
use App\Repository\OrdersDetailsRepository;
use App\Repository\OrdersRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
class AdminController extends AbstractController
{
    private Request $request;

    public function __construct(
        private ArticleRepository $articleRepository,
        private OrdersRepository $ordersRepository,
        private OrdersDetailsRepository $ordersDetailsRepository,
        private UserRepository $userRepository,
        private RequestStack $requestStack,
        private EntityManagerInterface $entityManager
    ) {
        $this->request = $requestStack->getCurrentRequest();
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/user', name:'admin.userAccount.form', methods:['GET', 'POST'])]
    public function userAccount(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('notice', 'Vos informations ont été mises à jour.');
            return $this->redirectToRoute('admin.userAccount.form');
        }

        return $this->render('admin/user/userAccount.html.twig', [
            'form' => $form->createView(),
            'users' => $this->userRepository->findAll(),
            'orders' => $this->ordersRepository->findAll(),
            'ordersDetails' => $this->ordersDetailsRepository->findAll(),
            'articles' => $this->articleRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/user/ship', name:'admin.shipUser.form', methods:['GET'])]
    #[Route('/user/update/{id}', name: 'security.register.update')]
    public function shipUser(): Response
    {
        return $this->render('admin/user/shipUser.html.twig', [
            'orders' => $this->ordersRepository->findAll(),
            'ordersDetails' => $this->ordersDetailsRepository->findAll(),
            'articles' => $this->articleRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/user/form', name: 'admin.user.form')]
    #[Route('/user/form/update/{id}', name: 'admin.user.form.update')]
    public function form(?int $id = null): Response
    {
        $type = RegisterType::class;
        $model = $id ? $this->userRepository->find($id) : new User();

        $form = $this->createForm($type, $model);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $id ? null : $this->entityManager->persist($model);
            $this->entityManager->flush();

            $notice = $id ? 'User Updated' : 'User added';
            $this->addFlash('notice', $notice);

            return $this->redirectToRoute('admin.userAccount.form');
        }

        return $this->render('admin/user/userAccount.html.twig', [
            'form' => $form,
        ]);
    }
}