<?php


namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\Calculator;
class CalculatorTest extends TestCase
{
    public $calculator = null;
    public function setUp(): void
    {
        $this->calculator = new Calculator();
    }

    public function test_add()
    {
        $result = $this->calculator->add(2, 2);
        $expected = 4;

        $this->assertEquals($expected, $result);
    }

    public function test_subtract()
    {
        $result = $this->calculator->subtract(7, 2);
        $expected = 5;

        $this->assertEquals($expected, $result);
    }

    public function test_multiply()
    {
        $result = $this->calculator->multiply(7, 2);
        $expected = 14;

        $this->assertEquals($expected, $result);
    }

    public function test_divide()
    {
        $result = $this->calculator->divide(6, 2);
        $expected = 3;

        $this->assertEquals($expected, $result);
    }

}
