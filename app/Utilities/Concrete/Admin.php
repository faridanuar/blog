<?php

namespace App\Utilities\Concrete;

use App\Utilities\Abstract\Person;
use App\Utilities\Interface\Info;

class Admin extends Person implements Info
{
    public function introduce()
    {
        return "This admin name is {$this->name}.";
    }

    public function age()
    {
        return "This admin age is {$this->age}.";
    }

    public function role()
    {
        return "This person have an Admin role.";
    }
}