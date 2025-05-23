<?php

/**
 * Category controller.
 */

namespace App\Controller;

use App\Entity\Category;
use App\Form\Type\CategoryType;
use App\Interface\CategoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Controller responsible for managing categories.
 */
class CategoryController extends AbstractController
{
    public $translator;
    public $categoryService;

    /**
     * Constructor.
     *
     * @param CategoryServiceInterface $categoryService the category service
     * @param TranslatorInterface      $translator      the translator service
     */
    public function __construct(CategoryServiceInterface $categoryService, TranslatorInterface $translator)
    {
        $this->categoryService = $categoryService;
        $this->translator = $translator;
    }

    /**
     * Displays the list of categories.
     *
     * @param int $page The page number
     *
     * @return Response the response object
     */
    #[\Symfony\Component\Routing\Attribute\Route('/categories', name: 'category_index')]
    public function index(#[MapQueryParameter] int $page = 1): Response
    {
        $pagination = $this->categoryService->getPaginatedCategories($page);

        return $this->render('category/index.html.twig', [
            'categories' => $pagination,
        ]);
    }

    /**
     * Displays the form to create a new category.
     *
     * @param Request $request The request object
     * @param int     $page    The page number
     *
     * @return Response the response object
     */
    #[\Symfony\Component\Routing\Attribute\Route('/categories/create', name: 'category_create')]
    public function create(Request $request, #[MapQueryParameter] int $page = 1): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        $pagination = $this->categoryService->getPaginatedCategories($page);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryService->save($category);

            $this->addFlash(
                'success',
                $this->translator->trans('Category created successfully')
            );

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/create.html.twig', [
            'form' => $form->createView(),
            'categories' => $pagination,
        ]);
    }
}
