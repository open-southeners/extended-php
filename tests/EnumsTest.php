<?php

namespace OpenSoutheners\LaravelHelpers\Tests;

use Exception;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\Model;
use function OpenSoutheners\LaravelHelpers\enum_is_backed;
use function OpenSoutheners\LaravelHelpers\enum_to_array;
use function OpenSoutheners\LaravelHelpers\enum_values;
use function OpenSoutheners\LaravelHelpers\get_enum_class;
use function OpenSoutheners\LaravelHelpers\has_case;
use function OpenSoutheners\LaravelHelpers\is_enum;
use OpenSoutheners\LaravelHelpers\Tests\Fixtures\Models\Post;
use OpenSoutheners\LaravelHelpers\Tests\Fixtures\MyBackedEnum;
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

    public function test_enum_is_backed(): void
    {
        $this->assertFalse(enum_is_backed(MyEnum::class));
        $this->assertTrue(enum_is_backed(MyBackedEnum::class));

        $this->expectException(Exception::class);
        $this->expectErrorMessage('Class or object is not an enum.');
        enum_is_backed(Post::class);
    }

    public function test_has_case(): void
    {
        $this->assertTrue(has_case(MyEnum::class, 'First'));
        $this->assertFalse(has_case(MyEnum::class, 'Something'));
        $this->assertFalse(has_case(Post::class, 'First'));
        $this->assertFalse(has_case(Model::class, 'First'));
        $this->assertFalse(has_case(HasAttributes::class, 'First'));
    }

    public function test_get_enum_class(): void
    {
        $this->assertEquals(get_enum_class(MyEnum::First), MyEnum::class);
        $this->assertEquals(get_enum_class(MyBackedEnum::tryFrom('first')), MyBackedEnum::class);
    }

    public function test_enum_to_array(): void
    {
        $myEnumArr = enum_to_array(MyEnum::First);
        $myBackedEnumArr = enum_to_array(MyBackedEnum::tryFrom('first'));

        $this->assertIsArray($myEnumArr);
        $this->assertIsArray($myBackedEnumArr);
        $this->assertEmpty(array_diff($myEnumArr, ['First', 'Second', 'Third']));
        $this->assertEmpty(array_diff($myBackedEnumArr, ['First' => 'first', 'Second' => 'second', 'Third' => 'third']));
    }

    public function test_enum_values(): void
    {
        $this->assertFalse(enum_values(MyEnum::First));
        $this->assertFalse(enum_values(MyEnum::class));

        $myBackedEnumValuesArr = enum_values(MyBackedEnum::class);

        $this->assertIsArray($myBackedEnumValuesArr);
        $this->assertEmpty(array_diff($myBackedEnumValuesArr, ['first', 'second', 'third']));
    }
}
