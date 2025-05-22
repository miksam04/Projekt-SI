<?php

/**
 * Category service.
 */

namespace App\Service;

use App\Interface\CategoryServiceInterface;
use App\Repository\CategoryRepository;
use App\Entity\Category;

/**
 * Service responsible for managing categories.
 *
 * This service handles operations such as retrieving all categories,
 * fetching categories by their ID, and other business logic related
 * to categories.
 */
class CategoryService implements CategoryServiceInterface
{
    /**
     * CategoryService constructor.
     *
     * @param CategoryRepository $categoryRepository The category repository
     */
    public function __construct(private readonly CategoryRepository $categoryRepository)
    {
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
}
