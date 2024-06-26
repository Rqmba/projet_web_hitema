<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    private Request $request;

    public function __construct(
        private RequestStack $requestStack,
        private EntityManagerInterface $entityManager,
        private ContactRepository $contactRepository,
        ) 
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    #[Route('/contact', name:'contact.form')]
    public function contactForm(): Response
    {
        $type = ContactType::class;
        $model = new Contact();

        $form = $this->createForm($type, $model);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('notice', 'Votre requête a été envoyé');
            return $this->redirectToRoute('contact.form');
        }
        return $this->render('form/contactForm.html.twig',[
            'form' => $form,
        ]);
    }
}