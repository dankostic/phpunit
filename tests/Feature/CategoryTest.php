<?php

namespace Tests\Feature;

use App\Models\Category;
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
                ]
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
                ]
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
                                        'name' => 'Ice hockey',
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
                    ['id' => 3, 'name' => 'Ice hockey', 'parent_id' => 2],
                ]
            ],
        ];
    }
}
