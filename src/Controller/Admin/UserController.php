<?php
namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[IsGranted('ROLE_SUPER_ADMIN')]
#[Route('/admin/user')]

class UserController extends AbstractController
{
    private Request $request;

    public function __construct(
        private RequestStack $requestStack,
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository,
        private SluggerInterface $sluggerInterface
    ) 
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    #[Route('/list', name: 'admin.user.list')]
    public function userList(): Response
    {
        return $this->render('admin/user/userList.html.twig', [
            'users' => $this->userRepository->findAll(),
        ]);
    }

    #[Route('/form/remove/{id}', name: 'admin.user.form.remove')]
    public function remove(int $id): Response
    {
        $model = $this->userRepository->find($id);

        if ($model) {
            $model->setDeletedAt(new DateTime());
            $this->entityManager->flush();
            $this->addFlash('notice', 'User removed');
        } else {
            $this->addFlash('error', 'User not found');
        }

        return $this->redirectToRoute('admin.user.list');
    }

    #[Route('/restore/{id}', name: 'admin.user.form.restore')]
    public function restore(int $id): Response
    {
        $model = $this->userRepository->find($id);

        if ($model) {
            $model->setDeletedAt(null);
            $this->entityManager->flush();
            $this->addFlash('notice', 'User restored');
        } else {
            $this->addFlash('error', 'User not found');
        }

        return $this->redirectToRoute('admin.user.list');
    }
}