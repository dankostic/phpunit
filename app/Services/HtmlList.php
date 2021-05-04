<?php


namespace App\Services;


use App\Models\Category;

class HtmlList extends Category
{
    /**
     * @var string
     */
    public $open_ul = '<ul>';
    /**
     * @var string
     */
    public $open_li = '<li>';
    /**
     * @var string
     */
    public $close_ul = '</ul>';
    /**
     * @var string
     */
    public $close_li = '</li>';

    /**
     * @param array $array
     * @return string
     */
    public function makeUlList(array $array): string
    {
        $this->categoryList .= $this->open_ul;
        foreach ($array as $value) {
            $this->categoryList .= $this->open_li . $value['name'];
            if (!empty($value['children'])) {
                $this->makeUlList($value['children']);
            }
            $this->categoryList .= $this->close_li;
        }
        $this->categoryList .= $this->close_ul;
        return $this->categoryList;
    }
}
