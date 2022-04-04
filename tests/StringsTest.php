<?php

namespace OpenSoutheners\LaravelHelpers\Tests;

use OpenSoutheners\LaravelHelpers\Tests\Fixtures\Models\Post;
use PHPUnit\Framework\TestCase;
use OpenSoutheners\LaravelHelpers\Tests\Fixtures\MyEnum;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\Model;

use function OpenSoutheners\LaravelHelpers\Strings\is_json;

class StringsTest extends TestCase
{
    public function test_is_json(): void
    {
        $this->assertTrue(is_json('{}'));
        $this->assertTrue(is_json('[{}]'));
        $this->assertTrue(is_json('{"foo": "bar"}'));
        $this->assertTrue(is_json("{\"foo\": \"bar\"}"));
        $this->assertFalse(is_json("{\u0022foo\u0022: \u0022bar\u0022}"));
    }
}
