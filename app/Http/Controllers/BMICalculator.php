<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BMICalculator extends Controller
{
    public $mass;
    public $height;
    public $BMI;

    public function calculate()
    {
        return round ( $this->mass / pow($this->height,2), 1 );
    }

    public function getTextResultFromBMI()
    {
        if($this->BMI < 18)
            return 'Underweight';
        elseif($this->BMI >= 18 && $this->BMI <= 25)
            return 'Normal';
        else
            return 'Overweight';
    }
}
