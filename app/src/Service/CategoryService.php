<?php
namespace App\Service;

use App\Interface\CategoryServiceInterface;
use App\Repository\CategoryRepository;
use App\Entity\Category;

class CategoryService implements CategoryServiceInterface
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories(): array
    {
        return $this->categoryRepository->findAll();
    }

    public function getCategoryById(int $id): ?Category
    {
        return $this->categoryRepository->find($id);
    }
}