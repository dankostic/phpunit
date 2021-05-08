<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Football',
                'description' => 'Desc of Football'
            ],
            [
                'name' => 'Basketball',
                'description' => 'Desc of Basketball'
            ]

        ];
        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat['name'],
                'description' => $cat['description'],
            ]);
        }
    }
}
