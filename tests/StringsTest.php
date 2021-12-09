<?php

namespace D8vjork\LaravelHelpers\Tests;

use D8vjork\LaravelHelpers\Tests\Fixtures\Models\Post;
use PHPUnit\Framework\TestCase;
use D8vjork\LaravelHelpers\Tests\Fixtures\MyEnum;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\Model;

use function D8vjork\LaravelHelpers\Strings\is_json;

class StringsTest extends TestCase
{
    public function test_is_json(): void
    {
        $this->assertTrue(is_json('{}'));
        $this->assertTrue(is_json('[{}]'));
    }
}
