<?php
namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_SUPER_ADMIN')]
#[Route('/admin/category')]

class CategoryController extends AbstractController
{
    private Request $request;

    public function __construct(
        private RequestStack $requestStack,
        private EntityManagerInterface $entityManager,
        private CategoryRepository $categoryRepository,
    ) {
        $this->request = $requestStack->getCurrentRequest();
    }

    #[IsGranted('ROLE_SUPER_ADMIN')]
    #[Route('/list', name:'admin.category.list')]
    public function articleList(): Response
    {
        return $this->render('admin/category/categoryList.html.twig', [
            'categories' => $this->categoryRepository->findAll(),
        ]);
    }

    #[Route('/form', name: 'admin.category.form')]
    #[Route('/form/update/{id}', name: 'admin.category.form.update')]
    public function form(?int $id = null): Response
    {
        $type = CategoryType::class;
        $model = $id ? $this->categoryRepository->find($id) : new Category();

        $form = $this->createForm($type, $model);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {

            $id ? null : $this->entityManager->persist($model);
            $this->entityManager->flush();

            $notice = $id ? 'Category Updated' : 'Category added';
            $this->addFlash('notice', $notice);

            return $this->redirectToRoute('admin.category.form');
        }
        return $this->render('admin/category/form.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/form/remove/{id}', name: 'admin.category.form.remove')]
    public function remove(int $id): Response
    {
        $model = $this->categoryRepository->find($id);

        if ($model) {
            $this->entityManager->remove($model);
            $this->entityManager->flush();
            $this->addFlash('notice', 'Category removed');
        } else {
            $this->addFlash('error', 'Category not found');
        }

        return $this->redirectToRoute('admin.category.list');
    }
}