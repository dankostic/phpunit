<?php


namespace App\Services;

use App\Models\Category;

/**
 * Class CategoryFactory
 * @package App\Services
 *
 * Design pattern factory
 */

class CategoryFactory
{
    public static function create()
    {
        $categories = Category::all()->toArray();
        $htmlList = new HtmlList();
        $converted_array = $htmlList->convert($categories);

        return $htmlList->makeUlList($converted_array);
    }
}
