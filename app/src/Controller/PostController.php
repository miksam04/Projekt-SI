<?php

/**
 * Home controller.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use App\Interface\PostServiceInterface;
use App\Interface\CategoryServiceInterface;
use App\Entity\Post;
use App\Form\Type\PostType;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Controller responsible for managing posts and and filtering them.
 */
class PostController extends AbstractController
{
    public $postService;
    public $categoryService;
    public $translator;

    /**
     * Constructor.
     *
     * @param PostServiceInterface     $postService     the post service
     * @param CategoryServiceInterface $categoryService the category service
     * @param TranslatorInterface      $translator      the translator service
     */
    public function __construct(PostServiceInterface $postService, CategoryServiceInterface $categoryService, TranslatorInterface $translator)
    {
        $this->postService = $postService;
        $this->categoryService = $categoryService;
        $this->translator = $translator;
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
    #[\Symfony\Component\Routing\Attribute\Route('/post/{id}', requirements: ['id' => '[1-9]\d*'], name: 'post_show')]
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

    /**
     * Creates a new post.
     *
     * @param Request $request the request object
     *
     * @return Response the response object
     */
    #[\Symfony\Component\Routing\Attribute\Route('/post/create', name: 'post_create')]
    public function createPost(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->postService->savePost($post);

            $this->addFlash(
                'success',
                $this->translator->trans('Post created successfully')
            );

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/create.html.twig', [
            'form' => $form->createView(),
            'categories' => $this->categoryService->getAllCategories(),
        ]);
    }

    #[\Symfony\Component\Routing\Attribute\Route('/post/{id}/edit', requirements: ['id' => '[1-9]\d*'], name: 'post_edit', methods: 'GET|PUT')]
    /**
     * Displays the form to edit an existing post.
     *
     * @param Request $request the request object
     * @param Post    $post    the post entity
     *
     * @return Response the response object
     */
    public function editPost(Request $request, Post $post): Response
    {
        $defaultReturnUrl = $this->generateUrl('post_index');

        $returnToUrl = $request->query->get('returnTo', $defaultReturnUrl);


        $form = $this->createForm(
            PostType::class,
            $post,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('post_edit', ['id' => $post->getId(), 'returnTo' => $returnToUrl]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->postService->savePost($post);

            $this->addFlash(
                'success',
                $this->translator->trans('Post updated successfully')
            );

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/edit.html.twig', [
            'form' => $form->createView(),
            'post' => $post,
            'categories' => $this->categoryService->getAllCategories(),
            'cancel_url' => $returnToUrl,
        ]);
    }

    /**
     * Deletes a post.
     *
     * @param Request $request the request object
     * @param Post    $post    the post entity
     * @param int     $page    the page number
     *
     * @return Response the response object
     */
    #[\Symfony\Component\Routing\Attribute\Route('/post/{id}/delete', requirements: ['id' => '[1-9]\d*'], name: 'post_delete', methods: 'GET|DELETE')]
    public function deletePost(Request $request, Post $post, #[MapQueryParameter] int $page = 1): Response
    {
        $defaultReturnUrl = $this->generateUrl('post_index');

        $returnToUrl = $request->query->get('returnTo', $defaultReturnUrl);

        $form = $this->createForm(
            PostType::class,
            $post,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('post_delete', ['id' => $post->getId(), 'returnTo' => $returnToUrl]),
                'disabled' => true,
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->postService->deletePost($post);

            $this->addFlash(
                'success',
                $this->translator->trans('Post deleted successfully')
            );

            return $this->redirectToRoute('post_index');
        }



        return $this->render('post/delete.html.twig', [
            'form' => $form->createView(),
            'post' => $post,
            'cancel_url' => $returnToUrl,
        ]);
    }
}
