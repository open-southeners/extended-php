<?php

namespace OpenSoutheners\LaravelHelpers\Tests;

use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\Model;
use function OpenSoutheners\LaravelHelpers\has_case;
use function OpenSoutheners\LaravelHelpers\is_enum;
use OpenSoutheners\LaravelHelpers\Tests\Fixtures\Models\Post;
use OpenSoutheners\LaravelHelpers\Tests\Fixtures\MyEnum;
use PHPUnit\Framework\TestCase;
use stdClass;

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
        $this->assertFalse(is_enum(new stdClass()));
        $this->assertFalse(is_enum(''));
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
