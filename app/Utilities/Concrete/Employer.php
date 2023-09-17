<?php

namespace App\Utilities\Concrete;

use App\Utilities\Abstract\Person;
use App\Utilities\Interface\Info;

class Employer extends Person implements Info
{
    public function introduce()
    {
        return "This employer name is {$this->name}.";
    }

    public function age()
    {
        return "This employer age is {$this->age}.";
    }

    public function role()
    {
        return "This person have an Employer role.";
    }
}