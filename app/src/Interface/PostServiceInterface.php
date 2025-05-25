<?php

/**
 * Post interface.
 */

namespace App\Interface;

use App\Entity\Post;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface PostServiceInterface.
 */
interface PostServiceInterface
{
    /**
     * Return all posts.
     *
     * @param int $page the page number
     *
     * @return Post[]
     */
    public function getPaginatedPosts(int $page): PaginationInterface;

    /**
     * Return a post by its ID.
     *
     * @param int $id the post ID
     *
     * @return Post|null the post object or null if not found
     */
    public function getPostById(int $id): ?Post;

    /**
     * Return posts by category.
     *
     * @param int $categoryId the category ID
     * @param int $page       the page number
     *
     * @return PaginationInterface the paginated posts
     */
    public function getPostsByCategory(int $categoryId, int $page): PaginationInterface;

    /**
     * Save a post.
     *
     * @param Post $post the post object to save
     */
    public function savePost(Post $post): void;

    /**
     * Delete a post.
     *
     * @param Post $post the post object to delete
     */
    public function deletePost(Post $post): void;
}
