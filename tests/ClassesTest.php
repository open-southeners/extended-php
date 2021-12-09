<?php

namespace D8vjork\LaravelHelpers\Tests;

use D8vjork\LaravelHelpers\Tests\Fixtures\Models\Post;
use PHPUnit\Framework\TestCase;
use D8vjork\LaravelHelpers\Tests\Fixtures\MyEnum;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\Model;

use function D8vjork\LaravelHelpers\Classes\class_implement;
use function D8vjork\LaravelHelpers\Classes\class_namespace;
use function D8vjork\LaravelHelpers\Classes\class_use;

class ClassesTest extends TestCase
{
    public function test_class_namespace(): void
    {
        $this->assertEquals(class_namespace(MyEnum::class), 'D8vjork\LaravelHelpers\Tests\Fixtures');
        $this->assertEquals(class_namespace(Model::class), 'Illuminate\Database\Eloquent');
        $this->assertEquals(class_namespace(new Post()), 'D8vjork\LaravelHelpers\Tests\Fixtures\Models');
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
}
