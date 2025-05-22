<?php
namespace App\Controller;

use App\Interface\CategoryServiceInterface;
use App\Service\CategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private CategoryServiceInterface $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    #[Route('/categories', name: 'category_index')]
    public function index(CategoryServiceInterface $categoryService): Response
    {
        $categories = $categoryService->getAllCategories();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }
}
