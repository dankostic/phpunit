<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('category.index');
    }

    public function showCategory($id)
    {
        $category = 'Football';
        return view('category.index', compact('category'));
    }

    public function saveCategory(Request $request)
    {
        if($request->name == ''){
            $categorySaved = false;
        } else {
            $categorySaved = true;
        }
        return view('category.index', compact('categorySaved'));
    }

    public function editCategory()
    {
        $edit_category = 'Edit category';
        return view('category.index', compact('edit_category'));
    }

    public function deleteCategory($id)
    {
        $category_deleted = true;
        return view('category.index', compact('category_deleted'));
    }
}
