<?php

namespace OpenSoutheners\LaravelHelpers\Tests;

use OpenSoutheners\LaravelHelpers\Tests\Fixtures\Models\Post;
use OpenSoutheners\LaravelHelpers\Tests\Fixtures\MyClass;
use PHPUnit\Framework\TestCase;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\Model;

use function OpenSoutheners\LaravelHelpers\Classes\call;
use function OpenSoutheners\LaravelHelpers\Classes\call_static;
use function OpenSoutheners\LaravelHelpers\Classes\class_implement;
use function OpenSoutheners\LaravelHelpers\Classes\class_namespace;
use function OpenSoutheners\LaravelHelpers\Classes\class_use;

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
}
