<?php

/**
 * Category service.
 */

namespace App\Service;

use App\Interface\CategoryServiceInterface;
use App\Repository\CategoryRepository;
use App\Entity\Category;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Service responsible for managing categories.
 *
 * This service handles operations such as retrieving all categories,
 * fetching categories by their ID, and other business logic related
 * to categories.
 */
class CategoryService implements CategoryServiceInterface
{
    public $categoryRepository;
    public $paginator;
    private const ITEMS_PER_PAGE = 10;

    /**
     * CategoryService constructor.
     *
     * @param CategoryRepository $categoryRepository The category repository
     * @param PaginatorInterface $paginator          The paginator service
     */
    public function __construct(CategoryRepository $categoryRepository, PaginatorInterface $paginator)
    {
        $this->categoryRepository = $categoryRepository;
        $this->paginator = $paginator;
    }

    /**
     * Get all categories.
     *
     * @param int $page The page number
     *
     * @return PaginationInterface A pagination object containing Category objects
     */
    public function getPaginatedCategories(int $page): PaginationInterface
    {
        $query = $this->categoryRepository->queryAll();

        return $this->paginator->paginate($query, $page, self::ITEMS_PER_PAGE);
    }

    /**
     * Get all categories.
     *
     * @return array An array of Category objects
     */
    public function getAllCategories(): array
    {
        return $this->categoryRepository->findAll();
    }

    /**
     * Get a category by its ID.
     *
     * @param int $id The category ID
     *
     * @return Category|null The Category object or null if not found
     */
    public function getCategoryById(int $id): ?Category
    {
        return $this->categoryRepository->find($id);
    }

    /**
     * Save a category.
     *
     * @param Category $category The category to save
     */
    public function save(Category $category): void
    {
        $this->categoryRepository->save($category);
    }

    /**
     * Delete a category.
     *
     * @param Category $category The category to delete
     *
     * @return void return nothing
     */
    public function delete(Category $category): void
    {
        $this->categoryRepository->delete($category);
    }
}
