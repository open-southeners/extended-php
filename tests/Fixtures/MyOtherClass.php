<?php

namespace OpenSoutheners\ExtendedPhp\Tests\Fixtures;

class MyOtherClass extends MyClass
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
