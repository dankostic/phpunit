<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();

            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
        });

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
            Category::factory()->create([
                'name' => $cat['name'],
                'description' => $cat['description'],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
