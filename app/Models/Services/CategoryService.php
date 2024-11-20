<?php

namespace App\Models\Services;

use Illuminate\Support\Facades\DB;
use App\Http\Messages\ErrorMessages;
use App\Models\Repository\CategoryRepositoryInterface;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function getAll()
    {
        return $this->categoryRepository->all();
    }
    public function find($id)
    {
        return $this->categoryRepository->find($id);
    }
    public function createCategory($data)
    {
        return DB::transaction(function () use ($data) {
            $category = $this->categoryRepository->create($data);
            return $category;
        });
    }
    public function deleteCategory($idCategory)
    {
        return DB::transaction(function () use ($idCategory) {
            $category = $this->categoryRepository->find($idCategory);
            if (!$category) {
                return ErrorMessages::CATEGORY_NOT_FOUND;
            }
            $category = $this->categoryRepository->delete($category);
            return $category;
        });
    }
    public function updateCategory($idCategory, $data)
    {
        return DB::transaction(function () use ($idCategory, $data) {
            $category = $this->categoryRepository->find($idCategory);
            if (!$category) return ErrorMessages::CATEGORY_NOT_FOUND;

            return $this->categoryRepository->update($category,$data);
        });
    }
}
