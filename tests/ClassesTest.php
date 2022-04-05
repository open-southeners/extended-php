<?php

namespace OpenSoutheners\LaravelHelpers\Tests;

use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\Model;
use function OpenSoutheners\LaravelHelpers\Classes\call;
use function OpenSoutheners\LaravelHelpers\Classes\call_static;
use function OpenSoutheners\LaravelHelpers\Classes\class_implement;
use function OpenSoutheners\LaravelHelpers\Classes\class_namespace;
use function OpenSoutheners\LaravelHelpers\Classes\class_use;
use OpenSoutheners\LaravelHelpers\Tests\Fixtures\Models\Post;
use OpenSoutheners\LaravelHelpers\Tests\Fixtures\MyClass;
use PHPUnit\Framework\TestCase;
use ReflectionException;

class ClassesTest extends TestCase
{
    public function test_class_namespace(): void
    {
        $this->assertEquals(class_namespace(MyClass::class), 'OpenSoutheners\LaravelHelpers\Tests\Fixtures');
        $this->assertEquals(class_namespace(Model::class), 'Illuminate\Database\Eloquent');
        $this->assertEquals(class_namespace(new Post()), 'OpenSoutheners\LaravelHelpers\Tests\Fixtures\Models');
    }

    public function test_class_implement(): void
    {
        $this->assertTrue(class_implement(Model::class, Arrayable::class));
        $this->assertTrue(class_implement(new Post(), Arrayable::class));
        $this->assertFalse(class_implement(Post::class, Model::class));
        $this->assertFalse(class_implement(new Post(), Model::class));
        $this->assertFalse(class_implement(Post::class, HasAttributes::class));
        $this->assertFalse(class_implement(Post::class, 'This/Does/Not/Exists'));
    }

    public function test_class_use(): void
    {
        $this->assertTrue(class_use(Model::class, HasAttributes::class));
        $this->assertTrue(class_use(new Post(), HasAttributes::class, true));
        $this->assertFalse(class_use(Post::class, Model::class));
        $this->assertFalse(class_use(new Post(), Model::class, true));
        $this->assertFalse(class_use(Post::class, HasAttributes::class));
        $this->assertFalse(class_use(new Post(), HasAttributes::class));
        $this->assertFalse(class_use(Post::class, 'This/Does/Not/Exists'));
    }

    public function test_call()
    {
        $args = [
            'foo' => 'hello',
            'bar' => 'world',
        ];

        $this->assertTrue(call(MyClass::class, 'method'));
        $this->assertTrue(call(new MyClass(), 'method'));
        $this->assertEquals(call(MyClass::class, 'methodWithArgs', $args), $args);
        $this->assertEquals(call(new MyClass(), 'methodWithArgs', $args), $args);
        $this->assertTrue(call_static(MyClass::class, 'staticMethod'));
        $this->assertTrue(call_static(new MyClass(), 'staticMethod'));
        $this->assertEquals(call_static(MyClass::class, 'staticMethodWithArgs', $args), $args);
        $this->assertEquals(call_static(new MyClass(), 'staticMethodWithArgs', $args), $args);
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
