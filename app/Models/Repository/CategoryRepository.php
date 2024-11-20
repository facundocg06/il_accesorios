<?php

namespace App\Models\Repository;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all()
    {
        return Category::all();
    }
    public function create($data)
    {
        return Category::create($data);
    }
    public function update($category, $data){
        return $category->update($data);
    }
    public function delete($category){
        return $category->delete();
    }
    public function find($id){
        return Category::find($id);
    }
}
