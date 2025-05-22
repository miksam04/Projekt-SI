<?php
namespace App\Interface;

use App\Entity\Post;
use Knp\Component\Pager\Pagination\PaginationInterface;

interface PostServiceInterface 
{
    public function getPaginatedPosts(int $page): PaginationInterface;

    public function getPostById(int $id): ?Post;

    public function getPostsByCategory(int $categoryId, int $page): PaginationInterface;
}