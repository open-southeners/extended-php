<?php

namespace OpenSoutheners\ExtendedPhp\Tests;

use Exception;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use OpenSoutheners\ExtendedPhp\Tests\Fixtures\MyClass;
use OpenSoutheners\ExtendedPhp\Tests\Fixtures\MyInterface;
use OpenSoutheners\ExtendedPhp\Tests\Fixtures\MyOtherClass;
use OpenSoutheners\ExtendedPhp\Tests\Fixtures\MyTrait;
use PHPUnit\Framework\TestCase;
use ReflectionException;

use function OpenSoutheners\ExtendedPhp\Classes\call;
use function OpenSoutheners\ExtendedPhp\Classes\call_static;
use function OpenSoutheners\ExtendedPhp\Classes\class_implement;
use function OpenSoutheners\ExtendedPhp\Classes\class_namespace;
use function OpenSoutheners\ExtendedPhp\Classes\class_use;

class ClassesTest extends TestCase
{
    public function test_class_namespace(): void
    {
        $this->assertEquals(class_namespace(MyClass::class), 'OpenSoutheners\ExtendedPhp\Tests\Fixtures');
        $this->assertEquals(class_namespace(TestCase::class), 'PHPUnit\Framework');
        $this->assertEquals(class_namespace(ReflectionException::class), '');
    }

    public function test_class_implement(): void
    {
        $this->assertTrue(class_implement(new MyClass, MyInterface::class));
        $this->assertTrue(class_implement(MyClass::class, MyInterface::class));
        $this->assertFalse(class_implement(new MyClass, Exception::class));
        $this->assertFalse(class_implement(MyClass::class, MyTrait::class));
        $this->assertFalse(class_implement(MyClass::class, 'This/Does/Not/Exists'));
    }

    public function test_class_use(): void
    {
        $this->assertTrue(class_use(new MyClass, MyTrait::class, true));
        $this->assertTrue(class_use(MyOtherClass::class, MyTrait::class, true));
        $this->assertFalse(class_use(MyOtherClass::class, MyTrait::class));
        $this->assertFalse(class_use(MyClass::class, Exception::class));
        $this->assertFalse(class_use(new MyClass, Exception::class, true));
        $this->assertFalse(class_use(MyClass::class, HasAttributes::class));
        $this->assertFalse(class_use(new MyClass, HasAttributes::class));
        $this->assertFalse(class_use(MyClass::class, 'This/Does/Not/Exists'));
    }

    public function test_call()
    {
        $args = [
            'foo' => 'hello',
            'bar' => 'world',
        ];

        $this->assertTrue(call(MyClass::class, 'method'));
        $this->assertTrue(call(new MyClass, 'method'));
        $this->assertEquals(call(MyClass::class, 'methodWithArgs', $args), $args);
        $this->assertEquals(call(new MyClass, 'methodWithArgs', $args), $args);
        $this->assertTrue(call_static(MyClass::class, 'staticMethod'));
        $this->assertTrue(call_static(new MyClass, 'staticMethod'));
        $this->assertEquals(call_static(MyClass::class, 'staticMethodWithArgs', $args), $args);
        $this->assertEquals(call_static(new MyClass, 'staticMethodWithArgs', $args), $args);
    }

    public function test_call_static_method_as_non_static_throws_exception()
    {
        $this->expectException(Exception::class);
        call(MyClass::class, 'staticMethod');
    }

    public function test_call_a_no_args_method_with_args_does_not_throws_exception()
    {
        $args = ['foo' => 'hello'];

        $this->assertTrue(call(MyClass::class, 'method', $args));
    }

    public function test_call_a_no_args_static_method_with_args_does_not_throws_exception()
    {
        $args = ['foo' => 'hello'];

        $this->assertTrue(call_static(MyClass::class, 'staticMethod', $args));
    }

    public function test_call_a_protected_method_throws_exception()
    {
        $this->expectException(Exception::class);
        call(MyClass::class, 'hidden');
    }

    public function test_call_a_static_protected_method_throws_exception()
    {
        $this->expectException(Exception::class);
        call_static(MyClass::class, 'staticHidden');
    }

    public function test_call_a_non_static_method_as_static_throws_exception()
    {
        $this->expectException(Exception::class);
        call_static(MyClass::class, 'method');
    }

    public function test_call_a_non_existing_method_throws_exception()
    {
        $this->expectException(ReflectionException::class);
        call(MyClass::class, 'methodDoesNotExists');
    }

    public function test_call_a_non_existing_static_method_throws_exception()
    {
        $this->expectException(ReflectionException::class);
        call_static(MyClass::class, 'staticMethodDoesNotExists');
    }

    public function test_nested_call()
    {
        $this->assertEquals(call(MyClass::class, 'getAnotherClass.anotherMethod', [
            'getAnotherClass' => [
                'foo' => 'hello',
            ],
        ]), 'hello');
    }
}
