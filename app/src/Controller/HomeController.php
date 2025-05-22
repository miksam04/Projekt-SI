<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;

use App\Repository\PostRepository;
use App\Interface\PostServiceInterface;
use App\Interface\CategoryServiceInterface;


class HomeController extends AbstractController
{

    public function __construct(PostServiceInterface $postService, CategoryServiceInterface $categoryService)
    {
        $this->postService = $postService;
        $this->categoryService = $categoryService;
        
    }

    #[Route('/', name: 'post_index', methods: 'GET')]
    public function index(#[MapQueryParameter] int $page = 1): Response
    {
        $pagination = $this->postService->getPaginatedPosts($page);

        return $this->render('home/index.html.twig', [
            'posts' => $pagination,
            'categories' => $this->categoryService->getAllCategories(),
        ]);
    }

    #[Route('/post/{id}', name: 'post_show')]
    public function showPost(int $id): Response
    {
        $post = $this->postService->getPostById($id);

        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/category/{id}', name: 'category_filter')]
    public function filterByCategory(int $id): Response
    {
        $category = $this->categoryService->getCategoryById($id);

        $pagination = $this->postService->getPostsByCategory($id, $page);

        return $this->render('home/index.html.twig', [
            'posts' => $pagination,
            'categories' => $this->categoryService->getAllCategories(),
            'selectedCategory' => $category,
        ]);
    }
}
