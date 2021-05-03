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
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_convert_database_results_to_category_array()
    {
       $db_result = [
           ['id' => 1, 'name' => 'Football', 'parent_id' => null],
           ['id' => 2, 'name' => 'Basketball', 'parent_id' => null],
           ['id' => 3, 'name' => 'Ice Hockey', 'parent_id' => null],
       ];

       $after_conversion = [
           ['id' => 1, 'name' => 'Football', 'parent_id' => null, 'children' => []],
           ['id' => 2, 'name' => 'Basketball', 'parent_id' => null, 'children' => []],
           ['id' => 3, 'name' => 'Ice Hockey', 'parent_id' => null, 'children' => []],
       ];

       $this->assertEquals($after_conversion, $this->category->convert($db_result));
    }

    public function test_can_convert_database_results_to_one_level_category_nested_array()
    {
        $db_result = [
            ['id' => 1, 'name' => 'Football', 'parent_id' => null],
            ['id' => 2, 'name' => 'Premier league', 'parent_id' => 1],
        ];

        $after_conversion = [
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
            ],
        ];

        $this->assertEquals($after_conversion, $this->category->convert($db_result));
    }

    public function test_can_convert_database_results_to_two_level_category_nested_array()
    {
        $db_result = [
            ['id' => 1, 'name' => 'Football', 'parent_id' => null],
            ['id' => 2, 'name' => 'Premier league', 'parent_id' => 1],
            ['id' => 3, 'name' => 'Ice hockey', 'parent_id' => 2],
        ];

        $after_conversion = [
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
            ],
        ];

        $this->assertEquals($after_conversion, $this->category->convert($db_result));
    }
}
