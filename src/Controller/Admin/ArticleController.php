<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[IsGranted('ROLE_SUPER_ADMIN')]
#[Route('/admin/article')]
class ArticleController extends AbstractController
{
    private Request $request;

    public function __construct(
        private RequestStack $requestStack,
        private EntityManagerInterface $entityManager,
        private ArticleRepository $articleRepository,
        private SluggerInterface $sluggerInterface
    ) {
        $this->request = $requestStack->getCurrentRequest();
    }

    // #[IsGranted('ROLE_SUPER_ADMIN')]
    #[Route('/list', name:'admin.article.list')]
    public function articleList(): Response
    {
        return $this->render('admin/article/articleList.html.twig', [
            'articles' => $this->articleRepository->findAll(),
        ]);
    }

    // #[IsGranted('ROLE_SUPER_ADMIN')]
    #[Route('/form', name: 'admin.article.form')]
    #[Route('/form/update/{id}', name: 'admin.article.form.update')]
    public function form(?int $id = null): Response
    {
        $type = ArticleType::class;
        $model = $id ? $this->articleRepository->find($id) : new Article();

        $form = $this->createForm($type, $model);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$id) {
                $slug = $this->sluggerInterface->slug($model->getTitle())->lower();
                $model->setSlug($slug);
            }
            $id ? null : $this->entityManager->persist($model);
            $this->entityManager->flush();

            $notice = $id ? 'Article Updated' : 'Article added';
            $this->addFlash('notice', $notice);

            return $this->redirectToRoute('admin.article.list');
        }
        return $this->render('admin/article/form.html.twig', [
            'form' => $form,
        ]);
    }

    // #[IsGranted('ROLE_SUPER_ADMIN')]
    #[Route('/form/remove/{id}', name: 'admin.article.form.remove')]
    public function remove(int $id): Response
    {
        $model = $this->articleRepository->find($id);

        if ($model) {
            $this->entityManager->remove($model);
            $this->entityManager->flush();
            $this->addFlash('notice', 'Article removed');
        } else {
            $this->addFlash('error', 'Article not found');
        }

        return $this->redirectToRoute('admin.article.list');
    }
}
