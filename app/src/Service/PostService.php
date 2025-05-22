<?php

namespace App\Service;

use App\Interface\PostServiceInterface;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use App\Entity\Post;

class PostService implements PostServiceInterface
{
    private PostRepository $postRepository;
    private PaginatorInterface $paginator;
    private RequestStack $requestStack;
    private const ITEMS_PER_PAGE = 10;

    public function __construct(PostRepository $postRepository, PaginatorInterface $paginator, RequestStack $requestStack)
    {
        $this->postRepository = $postRepository;
        $this->paginator = $paginator;
        $this->requestStack = $requestStack;
    }

    public function getPaginatedPosts(int $page): PaginationInterface
    {
        $query = $this->postRepository->queryAll();
        return $this->paginator->paginate($query, $page, self::ITEMS_PER_PAGE);
    }

    public function getPostById(int $id): ?Post
    {
        return $this->postRepository->find($id);
    }

    public function getPostsByCategory(int $categoryId, int $page): PaginationInterface
    {
        $query = $this->postRepository->queryByCategory($categoryId);
        return $this->paginator->paginate($query, $page, self::ITEMS_PER_PAGE);
    }
}
