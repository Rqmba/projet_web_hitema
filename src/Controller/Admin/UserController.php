<?php
namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
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
    // #[IsGranted('ROLE_SUPER_ADMIN')]
    // #[Route('/user/form', name: 'admin.user.form')]
    // #[Route('/user/form/update/{id}', name: 'admin.user.form.update')]
    // public function form(?int $id = null): Response
    // {
    //     $type = UserType::class;
    //     $model = $id ? $this->userRepository->find($id) : new User();

    //     $form = $this->createForm($type, $model);
    //     $form->handleRequest($this->request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         if (!$id) {
    //             $slug = $this->sluggerInterface->slug($model->getTitle())->lower();
    //             $model->setSlug($slug);
    //         }
    //         $id ? null : $this->entityManager->persist($model);
    //         $this->entityManager->flush();

    //         $notice = $id ? 'User Updated' : 'User added';
    //         $this->addFlash('notice', $notice);

    //         return $this->redirectToRoute('admin.user.list');
    //     }
    //     return $this->render('admin/user/form.html.twig', [
    //         'form' => $form,
    //     ]);
    // }

    // #[IsGranted('ROLE_SUPER_ADMIN')]
    #[Route('/form/remove/{id}', name: 'admin.user.form.remove')]
    public function remove(int $id): Response
    {
        $model = $this->userRepository->find($id);

        if ($model) {
            $this->entityManager->remove($model);
            $this->entityManager->flush();
            $this->addFlash('notice', 'User removed');
        } else {
            $this->addFlash('error', 'User not found');
        }

        return $this->redirectToRoute('admin.user.list');
    }
}