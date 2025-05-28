<?php

/**
 * Post service.
 */

namespace App\Service;

use App\Interface\PostServiceInterface;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use App\Entity\Post;
use App\Entity\User;

/**
 * Service responsible for managing blog posts.
 *
 * This service provides methods to retrieve, paginate,
 * and filter posts by categories or other criteria.
 */
class PostService implements PostServiceInterface
{
    private const ITEMS_PER_PAGE = 10;

    /**
     * Constructor.
     *
     * @param PostRepository     $postRepository The post repository
     * @param PaginatorInterface $paginator      The paginator service
     * @param UserRepository     $userRepository The user repository
     */
    public function __construct(private readonly PostRepository $postRepository, private readonly PaginatorInterface $paginator, private readonly UserRepository $userRepository)
    {
    }

    /**
     * Get paginated posts.
     *
     * @param int $page The page number
     *
     * @return PaginationInterface The paginated posts
     */
    public function getPaginatedPosts(int $page): PaginationInterface
    {
        $query = $this->postRepository->queryAll();

        return $this->paginator->paginate($query, $page, self::ITEMS_PER_PAGE);
    }

    /**
     * Get posts by id.
     *
     * @param int $id The post id
     *
     * @return Post|null The post entity or null if not found
     */
    public function getPostById(int $id): ?Post
    {
        return $this->postRepository->find($id);
    }

    /**
     * Get posts by category.
     *
     * @param int $categoryId The category id
     * @param int $page       The page number
     *
     * @return PaginationInterface The paginated posts
     */
    public function getPostsByCategory(int $categoryId, int $page): PaginationInterface
    {
        $query = $this->postRepository->queryByCategory($categoryId);

        return $this->paginator->paginate($query, $page, self::ITEMS_PER_PAGE);
    }

    /**
     * Save a post.
     *
     * @param Post $post The post to save
     *
     * @return void returns nothing
     */
    public function savePost(Post $post): void
    {
        $author = $this->userRepository->findOneBy(['nickname' => 'Admin']);

        
        $post->setAuthor($author);
        $this->postRepository->savePost($post);
    }

    /**
     * Delete a post.
     *
     * @param Post $post The post to delete
     *
     * @return void returns nothing
     */
    public function deletePost(Post $post): void
    {
        $this->postRepository->deletePost($post);
    }
}
