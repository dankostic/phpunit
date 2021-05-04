<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $guarded = [];

    public $timestamps = false;

    /**
     * @var
     */
    public $categoryList;

    /**
     * @param array $array
     * @param int|null $parent_id
     * @return array
     */
    public function convert(array $array, int $parent_id = null): array
    {
        $nested_categories = [];

        foreach ($array as $category) {
            $category['children'] = [];
            if ($category['parent_id'] == $parent_id) {
               $children = $this->convert($array, $category['id']);
               if ($children) {
                   $category['children'] = $children;
               }
                $nested_categories[] = $category;
            }
        }
        return $nested_categories;
    }

    /**
     * @return object
     */
    public function children(): object
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * @return object
     */
    public function parent(): object
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
