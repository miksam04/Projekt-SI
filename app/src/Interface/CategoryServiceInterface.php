<?php

/**
 * Category interface.
 */

namespace App\Interface;

use App\Entity\Category;

/**
 * Interface CategoryServiceInterface.
 */
interface CategoryServiceInterface
{
    /**
     * Return paginated categories.
     *
     * @param int $page the page number
     *
     * @return Category[]
     */
    public function getPaginatedCategories(int $page);

    /**
     * Return all categories.
     *
     * @return Category[] an array of Category objects
     */
    public function getAllCategories(): array;

    /**
     * Return a category by its ID.
     *
     * @param int $id the category ID
     *
     * @return Category|null the category object or null if not found
     */
    public function getCategoryById(int $id): ?Category;

    /**
     * Save a category.
     *
     * @param Category $category the category to save
     */
    public function save(Category $category): void;
}
