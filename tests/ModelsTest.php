<?php

namespace D8vjork\LaravelHelpers\Tests;

use D8vjork\LaravelHelpers\Tests\Fixtures\Models\Post;
use D8vjork\LaravelHelpers\Tests\Fixtures\Models\User;
use D8vjork\LaravelHelpers\Tests\Fixtures\MyClass;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;

use function D8vjork\LaravelHelpers\Models\is_model;

class ModelsTest extends TestCase
{
    public function test_is_model(): void
    {
        $this->assertFalse(is_model(MyClass::class));
        $this->assertFalse(is_model(HasAttributes::class));
        $this->assertFalse(is_model(Model::class));
        $this->assertTrue(is_model(Post::class));
        $this->assertTrue(is_model(User::class));
    }
}
