<?php

namespace App\Http\Controllers;

/**
 * Class Calculator
 * @package App\Http\Controllers
 */
class Calculator extends Controller
{
    /**
     * @param int $a
     * @param int $b
     * @return int
     */
    public function add(int $a, int $b): int
    {
        return $a + $b;
    }

    /**
     * @param int $a
     * @param int $b
     * @return int
     */
    public function subtract(int $a, int $b): int
    {
        return $a - $b;
    }

    /**
     * @param int $a
     * @param int $b
     * @return int
     */
    public function multiply(int $a, int $b): int
    {
        return $a * $b;
    }

    /**
     * @param int $a
     * @param int $b
     * @return int
     */
    public function divide(int $a, int $b): int
    {
        return $a / $b;
    }
}
