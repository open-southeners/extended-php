<?php

namespace OpenSoutheners\LaravelHelpers\Tests\Fixtures;

class MyOtherClass
{
    /**
     * @var mixed
     */
    protected $foo;

    public function __construct($foo)
    {
        $this->foo = $foo;
    }

    public function anotherMethod()
    {
        return $this->foo;
    }

    protected function anotherHidden()
    {
        // 
    }
}
