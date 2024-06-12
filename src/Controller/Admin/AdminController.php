<?php

namespace App\Controller\Admin;

use App\Entity\OrdersDetails;
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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $userPasswordHasher,
    ) {
        $this->request = $requestStack->getCurrentRequest();
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/homepage', name:'admin.index', methods:['GET'])]
    public function adminIndex(): Response
    {
        return $this->render('admin/homepage/index.html.twig', [
            "articlesAllFigurines" => $this->articleRepository->getDataFigurines()->getResult(),
            "articlesDB" => $this->articleRepository->getDataArticleDB()->getResult(),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/user', name:'admin.userAccount.form', methods:['GET'])]
    public function userAccount(): Response
    {
        return $this->render('admin/user/userAccount.html.twig', [
            'users' => $this->userRepository->findAll(),
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


    public function register(?int $id = null): Response
    {
        $type = RegisterType::class;
        $model = $id ? $this->userRepository->find($id) : new User();
        $form_register = $this->createForm($type, $model);
        $form_register->handleRequest($this->request);

        if ($form_register->isSubmitted() && $form_register->isValid()) {
            $model->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $model,
                    $form_register->get('password')->getData()
                )
            );

            $id ? null : $this->entityManager->persist($model);
            $this->entityManager->flush();

            $notice = $id ? 'Account Updated' : 'Account created';
            $this->addFlash('notice', $notice);

            return $this->redirectToRoute('security.login');
        }

        return $this->render('security/register.html.twig', [
            'form' => $form_register,
        ]);
    }

    // #[IsGranted('ROLE_USER')]
    // #[Route('/user/ship/{id}', name: 'admin.shipUser.remove')]
    // public function removeArticle(int $id): Response
    // {
    //     $order = $this->articleRepository->find($id);
    // }
}