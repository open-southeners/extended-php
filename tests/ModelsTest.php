<?php

namespace OpenSoutheners\LaravelHelpers\Tests;

use Exception;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use function OpenSoutheners\LaravelHelpers\Models\instance_from;
use function OpenSoutheners\LaravelHelpers\Models\is_model;
use function OpenSoutheners\LaravelHelpers\Models\key_from;
use function OpenSoutheners\LaravelHelpers\Models\model_from;
use OpenSoutheners\LaravelHelpers\Tests\Fixtures\Models\Post;
use OpenSoutheners\LaravelHelpers\Tests\Fixtures\Models\User;
use OpenSoutheners\LaravelHelpers\Tests\Fixtures\Models\UuidModel;
use OpenSoutheners\LaravelHelpers\Tests\Fixtures\MyClass;
use PHPUnit\Framework\TestCase;

class ModelsTest extends TestCase
{
    public function test_model_from(): void
    {
        $this->assertIsString(model_from('Post', true, 'OpenSoutheners\LaravelHelpers\Tests\Fixtures\Models\\'));
        $this->assertIsString(model_from('post', true, 'OpenSoutheners\LaravelHelpers\Tests\Fixtures\Models\\'));
        $this->assertTrue(model_from('post', false, 'OpenSoutheners\LaravelHelpers\Tests\Fixtures\Models\\') instanceof Post);
    }

    public function test_is_model(): void
    {
        $this->assertFalse(is_model(MyClass::class));
        $this->assertFalse(is_model(HasAttributes::class));
        $this->assertFalse(is_model(Model::class));
        $this->assertTrue(is_model(Post::class));
        $this->assertTrue(is_model(User::class));
    }

    public function test_instance_from(): void
    {
        $myClass = new MyClass();

        $this->expectException(Exception::class);
        instance_from($myClass, Post::class);

        $myClass = Model::class;

        $this->expectException(ModelNotFoundException::class);
        instance_from(Model::class, Post::class);

        $this->assertTrue(instance_from('1', Post::class) instanceof Post);
        $this->assertTrue(instance_from(2, User::class) instanceof User);
    }

    public function test_key_from()
    {
        $model = new Post(['id' => 1]);

        $modelKey = key_from($model);
        $this->assertIsNumeric($modelKey);
        $this->assertEquals(1, $modelKey);

        $model = new UuidModel(['uuid' => '7c3a3e74-b602-4e0a-8003-bd7faeefde3d']);

        $modelKey = key_from($model);
        $this->assertIsNotNumeric($modelKey);
        $this->assertIsString($modelKey);
        $this->assertEquals('7c3a3e74-b602-4e0a-8003-bd7faeefde3d', $modelKey);

        $modelKey = key_from($model->uuid);
        $this->assertIsNotNumeric($modelKey);
        $this->assertIsString($modelKey);
        $this->assertEquals('7c3a3e74-b602-4e0a-8003-bd7faeefde3d', $modelKey);

        $myClass = new MyClass();
        $modelKey = key_from($myClass);
        $this->assertNull($modelKey);
    }
}
