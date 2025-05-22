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
     * Return all categories.
     *
     * @return Category[]
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
}
