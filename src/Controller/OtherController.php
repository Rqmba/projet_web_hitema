<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OtherController extends AbstractController
{
    readonly private Request $request;

    public function __construct(
        readonly private RequestStack $requestStack,
        private EntityManagerInterface $entityManager,
        ) 
    
        {
        $this->request = $requestStack->getCurrentRequest();
    }

    #[Route('/other/faq', name:'other.faq', methods: ['GET'])]
    public function otherFaq():Response
    {
        return $this->render('other/faq.html.twig');
    }

    #[Route('/other/news', name: 'other.news', methods: ['GET'])]
    public function otherNews():Response
    {
        return $this->render('other/news.html.twig');
    }

    #[Route('other/Conditions_ventes', name: 'other.cdeventes', methods: ['GET'])]
    public function otherCdeventes():Response
    {
        return $this->render('other/Cdeventes.html.twig');
    }

    #[Route('other/ContactUs', name: 'other.contactus', methods: ['GET'])]
    public function othercontactUs():Response
    {
        return $this->render('other/contactUs.html.twig');
    }

    #[Route('other/Frais_de_livraison', name: 'other.livraison', methods: ['GET'])]
    public function otherlivraison():Response
    {
        return $this->render('other/Fdelivraison.html.twig');
    }

    #[Route('other/Conditions_de_retour', name:'other.retours', methods:['GET'])]
    public function otherRetours():Response
    {
        return $this->render('other/Retour_livraison.html.twig');
    }
}