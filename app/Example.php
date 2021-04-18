<?php

namespace App;

use App\ExampleInner;

class Example
{

    protected ExampleInner $foo;

    public function __construct(ExampleInner $foo, $a)
    {

        $this->foo=$foo;

    }
}

