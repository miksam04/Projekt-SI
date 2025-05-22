<?php
namespace App\Interface;

use App\Entity\Category;

interface CategoryServiceInterface
{
    public function getAllCategories(): array;

    public function getCategoryById(int $id): ?Category;
}