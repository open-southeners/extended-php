<?php

namespace OpenSoutheners\LaravelHelpers\Tests;

use Exception;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder as BaseBuilder;
use Mockery;

use function OpenSoutheners\LaravelHelpers\Models\instance_from;
use function OpenSoutheners\LaravelHelpers\Models\is_model;
use function OpenSoutheners\LaravelHelpers\Models\key_from;
use function OpenSoutheners\LaravelHelpers\Models\model_from;
use function OpenSoutheners\LaravelHelpers\Models\query_from;

use OpenSoutheners\LaravelHelpers\Tests\Fixtures\Models\Post;
use OpenSoutheners\LaravelHelpers\Tests\Fixtures\Models\User;
use OpenSoutheners\LaravelHelpers\Tests\Fixtures\Models\UuidModel;
use OpenSoutheners\LaravelHelpers\Tests\Fixtures\MyClass;
use PHPUnit\Framework\TestCase;
use ReflectionException;

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
        $post = new Post(['id' => 1]);
        $user = new User(['id' => 2]);

        $this->mockConnectionForModel($post, 'SQLite', function ($connection) {
            $connection->shouldReceive('select')->andReturn(['id' => 1]);
            $connection->shouldReceive('find')->with(1)->andReturn(['id' => 1]);
        });
        
        $this->mockConnectionForModel($user, 'SQLite', function ($connection) {
            $connection->shouldReceive('select')->andReturn(['id' => 2]);
            $connection->shouldReceive('find')->with(2)->andReturn(['id' => 2]);
        });

        $this->assertTrue(instance_from($post, Post::class) instanceof Post);
        $this->assertTrue(instance_from($user, User::class) instanceof User);
        $this->assertTrue(instance_from(new User(['id' => 2]), User::class) instanceof User);
    }

    public function test_instance_from_with_non_existing_class_as_key_throws_exception()
    {
        $this->expectException(ModelNotFoundException::class);
        instance_from('App\Post', Post::class);
    }
    
    public function test_instance_from_with_non_existing_class_throws_exception()
    {
        $this->expectException(ModelNotFoundException::class);
        instance_from(1, 'App\Post');
    }

    public function test_instance_from_with_extended_class_as_key_throws_exception()
    {
        $this->expectException(ModelNotFoundException::class);
        instance_from(Model::class, Post::class);
    }
    
    public function test_instance_from_an_unexisting_model_throws_exception()
    {
        $this->expectException(ModelNotFoundException::class);
        instance_from(1, Post::class);
    }
    
    public function test_instance_from_with_different_classes_throws_exception()
    {
        $this->expectException(Exception::class);
        instance_from(new MyClass(), Post::class);
    }

    public function test_key_from()
    {
        $model = new Post(['id' => 1]);

        $modelKey = key_from($model);
        $this->assertIsNumeric($modelKey);
        $this->assertEquals(1, $modelKey);
        
        $modelKey = key_from('122');
        $this->assertIsNumeric($modelKey);
        $this->assertEquals(122, $modelKey);

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

    public function test_query_from()
    {
        $model = new Post(['id' => 1]);

        $this->mockConnectionForModel($model, 'SQLite');

        $this->assertTrue(query_from($model) instanceof Builder);
        $this->assertFalse(query_from($model) instanceof Model);
        $this->assertTrue(query_from(Post::class) instanceof Builder);
        $this->assertTrue(query_from(Post::query()) instanceof Builder);

        $modelQuery = Post::query()->whereKey(1);

        $this->assertNotEquals(query_from($modelQuery)->toSql(), $modelQuery->toSql());
    }

    protected function mockConnectionForModel($model, $database, $callback = null)
    {
        $grammarClass = 'Illuminate\Database\Query\Grammars\\'.$database.'Grammar';
        $processorClass = 'Illuminate\Database\Query\Processors\\'.$database.'Processor';
        $grammar = new $grammarClass;
        $processor = new $processorClass;
        $connection = Mockery::mock(ConnectionInterface::class, ['getQueryGrammar' => $grammar, 'getPostProcessor' => $processor]);
        $connection->shouldReceive('query')->andReturnUsing(function () use ($connection, $grammar, $processor) {
            return new BaseBuilder($connection, $grammar, $processor);
        });
        $connection->shouldReceive('getDatabaseName')->andReturn('database');
        $connection->shouldReceive('getName')->andReturn('sqlite');

        if ($callback && is_callable($callback)) {
            $callback($connection);
        }

        $resolver = Mockery::mock(ConnectionResolverInterface::class, ['connection' => $connection]);
        $class = get_class($model);
        $class::setConnectionResolver($resolver);
    }
}
