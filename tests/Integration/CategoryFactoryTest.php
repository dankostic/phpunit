<?php


namespace Tests\Integration;


use App\Services\CategoryFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CategoryFactoryTest extends TestCase
{
    use DatabaseMigrations;

    public function test_can_produce_string_based_on_array()
    {
        $this->assertTrue(is_string(CategoryFactory::create()));
    }
}
