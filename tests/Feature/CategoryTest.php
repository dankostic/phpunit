<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Services\HtmlList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    protected $category;
    public function setUp(): void
    {
        $this->category = new Category();
    }

    /**
     * @dataProvider arrayProvider
     */
    public function test_can_convert_database_results_to_category_nested_array($after_conversion, $db_result)
    {
        $this->assertEquals($after_conversion, $this->category->convert($db_result));
    }

    /**
     * @dataProvider arrayProvider
     */
    public function test_can_produce_html_nested_categories($after_conversion, $db_result, $html_list)
    {
        $html = new HtmlList();
        $after_conversion = $html->convert($db_result);
        $this->assertEquals($html_list, $html->makeUlList($after_conversion));
    }

    public function arrayProvider()
    {
        return [
            'one level' => [
                [
                    ['id' => 1, 'name' => 'Football', 'parent_id' => null, 'children' => []],
                    ['id' => 2, 'name' => 'Basketball', 'parent_id' => null, 'children' => []],
                    ['id' => 3, 'name' => 'Ice Hockey', 'parent_id' => null, 'children' => []],
                ],
                [
                    ['id' => 1, 'name' => 'Football', 'parent_id' => null],
                    ['id' => 2, 'name' => 'Basketball', 'parent_id' => null],
                    ['id' => 3, 'name' => 'Ice Hockey', 'parent_id' => null],
                ],
                '<ul><li>Football</li><li>Basketball</li><li>Ice Hockey</li></ul>'
            ],
            'two level' => [
                [
                    [
                        'id' => 1,
                        'name' => 'Football',
                        'parent_id' => null,
                        'children' => [
                            [
                                'id' => 2,
                                'name' => 'Premier league',
                                'parent_id' => 1,
                                'children' => []
                            ]
                        ]
                    ]
                ],
                [
                    ['id' => 1, 'name' => 'Football', 'parent_id' => null],
                    ['id' => 2, 'name' => 'Premier league', 'parent_id' => 1],
                ],
                '<ul><li>Football<ul><li>Premier league</li></ul></li></ul>'
            ],
            'three level' => [
                [
                    [
                        'id' => 1,
                        'name' => 'Football',
                        'parent_id' => null,
                        'children' => [
                            [
                                'id' => 2,
                                'name' => 'Premier league',
                                'parent_id' => 1,
                                'children' => [
                                    [
                                        'id' => 3,
                                        'name' => 'Arsenal',
                                        'parent_id' => 2,
                                        'children' => []
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    ['id' => 1, 'name' => 'Football', 'parent_id' => null],
                    ['id' => 2, 'name' => 'Premier league', 'parent_id' => 1],
                    ['id' => 3, 'name' => 'Arsenal', 'parent_id' => 2],
                ],
                '<ul><li>Football<ul><li>Premier league<ul><li>Arsenal</li></ul></li></ul></li></ul>'
            ],
        ];
    }
}
