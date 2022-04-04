<?php

namespace OpenSoutheners\LaravelHelpers\Tests;

use OpenSoutheners\LaravelHelpers\Tests\Fixtures\Models\Post;
use PHPUnit\Framework\TestCase;
use OpenSoutheners\LaravelHelpers\Tests\Fixtures\MyEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;

use function OpenSoutheners\LaravelHelpers\has_case;
use function OpenSoutheners\LaravelHelpers\is_enum;

/**
 * @group needsPhp81
 */
class EnumsTest extends TestCase
{
    public function test_is_enum(): void
    {
        $this->assertTrue(is_enum(MyEnum::class));
        $this->assertFalse(is_enum(Post::class));
        $this->assertFalse(is_enum(Model::class));
        $this->assertFalse(is_enum(HasAttributes::class));
    }
    
    public function test_has_case(): void
    {
        $this->assertTrue(has_case(MyEnum::class, 'First'));
        $this->assertFalse(has_case(MyEnum::class, 'Something'));
        $this->assertFalse(has_case(Post::class, 'First'));
        $this->assertFalse(has_case(Model::class, 'First'));
        $this->assertFalse(has_case(HasAttributes::class, 'First'));
    }
}
