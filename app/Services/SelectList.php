<?php


namespace App\Services;


use App\Models\Category;

class SelectList extends Category
{
    public function makeSelectList(array $array, int $repeat = 0): array
    {
        foreach ($array as $value) {
            $this->categoryList[] = ['name' => str_repeat("&nbsp;", $repeat) . $value['name']];
            if (!empty($value['children'])) {
                $repeat = $repeat + 2;
                $this->makeSelectList($value['children'], $repeat);
            }
        }
        return $this->categoryList;
    }
}
