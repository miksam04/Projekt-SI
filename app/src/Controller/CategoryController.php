<?php

/**
 * Category controller.
 */

namespace App\Controller;

use App\Interface\CategoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller responsible for managing categories.
 */
class CategoryController extends AbstractController
{
    /**
     * Constructor.
     *
     * @param CategoryServiceInterface $categoryService the category service
     */
    public function __construct(private readonly CategoryServiceInterface $categoryService)
    {
    }

    /**
     * Displays the list of categories.
     *
     * @return Response the response object
     */
    #[\Symfony\Component\Routing\Attribute\Route('/categories', name: 'category_index')]
    public function index(): Response
    {
        $categories = $categoryService->getAllCategories();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }
}
