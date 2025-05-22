<?php

/**
 * Home controller.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use App\Interface\PostServiceInterface;
use App\Interface\CategoryServiceInterface;

/**
 * Controller responsible for managing posts and and filtering them.
 */
class HomeController extends AbstractController
{
    public $postService;
    public $categoryService;

    /**
     * Constructor.
     *
     * @param PostServiceInterface     $postService     the post service
     * @param CategoryServiceInterface $categoryService the category service
     */
    public function __construct(PostServiceInterface $postService, CategoryServiceInterface $categoryService)
    {
        $this->postService = $postService;
        $this->categoryService = $categoryService;
    }

    /**
     * Displays the list of posts.
     *
     * @param int $page the page number
     *
     * @return Response the response object
     */
    #[\Symfony\Component\Routing\Attribute\Route('/', name: 'post_index', methods: 'GET')]
    public function index(#[MapQueryParameter] int $page = 1): Response
    {
        $pagination = $this->postService->getPaginatedPosts($page);

        return $this->render('home/index.html.twig', [
            'posts' => $pagination,
            'categories' => $this->categoryService->getAllCategories(),
        ]);
    }

    /**
     * Displays a single post.
     *
     * @param int $id the post ID
     *
     * @return Response the response object
     */
    #[\Symfony\Component\Routing\Attribute\Route('/post/{id}', name: 'post_show')]
    public function showPost(int $id): Response
    {
        $post = $this->postService->getPostById($id);

        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * Filters posts by category.
     *
     * @param int $id   the category ID
     * @param int $page the page number
     *
     * @return Response the response object
     */
    #[\Symfony\Component\Routing\Attribute\Route('/category/{id}', name: 'category_filter')]
    public function filterByCategory(int $id, #[MapQueryParameter] int $page = 1): Response
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
