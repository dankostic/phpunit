<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class CategoryController
 * @package App\Http\Controllers
 */
class CategoryController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('category.index');
    }

    /**
     * @param $id
     * @return View
     */
    public function showCategory($id): View
    {
        $category = 'Football';
        return view('category.index', compact('category'));
    }

    /**
     * @param Request $request
     * @return View
     */
    public function saveCategory(Request $request): View
    {
        if($request->name == ''){
            $categorySaved = false;
        } else {
            $categorySaved = true;
        }
        return view('category.index', compact('categorySaved'));
    }

    /**
     * @return View
     */
    public function editCategory(): View
    {
        $edit_category = 'Edit category';
        return view('category.index', compact('edit_category'));
    }

    /**
     * @param $id
     * @return View
     */
    public function deleteCategory($id): View
    {
        $category_deleted = true;
        return view('category.index', compact('category_deleted'));
    }
}
