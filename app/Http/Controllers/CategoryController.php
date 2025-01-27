<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Messages\ErrorMessages;
use App\Http\Messages\SuccessMessages;
use App\Http\Requests\CategoryRequest;
use App\Models\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;
    
    public function __construct(CategoryService $categoryService){
        $this->categoryService = $categoryService;
    }

    public function category_list (){
        $categories = $this->categoryService->getAll();
        return view('content.category.category-list',compact('categories'));
    }
    public function register_category(CategoryRequest $categoryRequest){
        try {
            $this->categoryService->createCategory($categoryRequest->all());
            return redirect()->route('category-list')->with('success', SuccessMessages::CATEGORY_CREATED);
        } catch (Exception $e) {
            return redirect()->route('category-list')->with('error', ErrorMessages::CATEGORY_CREATION_ERROR);
        }
    }
    public function delete_category($idCategory){
        try {
            $this->categoryService->deleteCategory($idCategory);
            return redirect()->route('category-list')->with('success', SuccessMessages::CATEGORY_DELETED);
        } catch (Exception $e) {
            return redirect()->route('category-list')->with('error', ErrorMessages::CATEGORY_DELETE_ERROR);
        }
    }
    public function edit_category($idCategory){
    }
    public function update_category(Request $request, $id){
        try {
            $this->categoryService->updateCategory($id , $request->all());
            return redirect()->route('category-list')->with('success', SuccessMessages::CATEGORY_UPDATED);
        } catch (Exception $e) {
            return redirect()->route('category-list')->with('error', ErrorMessages::CATEGORY_UPDATE_ERROR);
        }
    }
}
