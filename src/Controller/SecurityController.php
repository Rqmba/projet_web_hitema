<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    readonly private Request $request;

    public function __construct(readonly private RequestStack $requestStack, private EntityManagerInterface $entityManager,private UserPasswordHasherInterface $userPasswordHasher, private UserRepository $userRepository) {
        $this->request = $requestStack->getCurrentRequest();
    }

    #[Route('/login', name: 'security.login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        $type = UserType::class;
        $model = new User();
        $form = $this->createForm($type, $model);
        $form->handleRequest($this->request);

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'form' => $form,
            'last_username' => $lastUsername, 
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'security.logout')]
    public function logout(): void
    {
        // throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/register', name: 'security.register')]
    #[Route('/register/update/{id}', name: 'security.register.update')]
    public function register(?int $id = null): Response
    {

        $type = RegisterType::class;
        $model = $id ? $this->userRepository->find($id) : new User();
        $form_register = $this->createForm($type, $model);
        $form_register->handleRequest($this->request);

        if ($form_register->isSubmitted() && $form_register->isValid()) {
            $model->setCreatedAt(new \DateTimeImmutable());
            $model->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $model,
                    $form_register->get('password')->getData()
                )
            );

        $id ? null :$this->entityManager->persist($model);
        $this->entityManager->flush();

        $notice = $id ? 'Acccount Updated' : 'Account created';

        $this->addFlash('notice', $notice);

        return $this->redirectToRoute('admin.index');

        }
        return $this->render('security/register.html.twig',[
            'form' => $form_register,
        ]);
    }
}
