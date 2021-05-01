<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Calculator extends Controller
{
    public function add($a, $b)
    {
        return $a + $b;
    }

    public function subtract($a, $b)
    {
        return $a - $b;
    }

    public function multiply ($a, $b)
    {
        return $a * $b;
    }

    public function divide ($a, $b)
    {
        return $a / $b;
    }
}
