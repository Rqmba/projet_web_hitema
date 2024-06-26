<?php
namespace App\Controller\Admin;

use App\Entity\Manga;
use App\Form\MangaType;
use App\Repository\MangaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_SUPER_ADMIN')]
#[Route('/admin/manga')]

class MangaController extends AbstractController
{
    private Request $request;

    public function __construct(
        private RequestStack $requestStack,
        private EntityManagerInterface $entityManager,
        private MangaRepository $mangaRepository,
    ) {
        $this->request = $requestStack->getCurrentRequest();
    }

    #[IsGranted('ROLE_SUPER_ADMIN')]
    #[Route('/list', name:'admin.manga.list')]
    public function articleList(): Response
    {
        return $this->render('admin/manga/mangaList.html.twig', [
            'mangas' => $this->mangaRepository->findAll(),
        ]);
    }

    #[Route('/form', name: 'admin.manga.form')]
    #[Route('/form/update/{id}', name: 'admin.manga.form.update')]
    public function form(?int $id = null): Response
    {
        $type = MangaType::class;
        $model = $id ? $this->mangaRepository->find($id) : new Manga;

        $form = $this->createForm($type, $model);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {

            $id ? null : $this->entityManager->persist($model);
            $this->entityManager->flush();

            $notice = $id ? 'Manga Updated' : 'Manga added';
            $this->addFlash('notice', $notice);

            return $this->redirectToRoute('admin.manga.form');
        }
        return $this->render('admin/manga/form.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/form/remove/{id}', name: 'admin.manga.form.remove')]
    public function remove(int $id): Response
    {
        $model = $this->mangaRepository->find($id);

        if ($model) {
            $this->entityManager->remove($model);
            $this->entityManager->flush();
            $this->addFlash('notice', 'Manga removed');
        } else {
            $this->addFlash('error', 'Manga not found');
        }

        return $this->redirectToRoute('admin.manga.list');
    }
}