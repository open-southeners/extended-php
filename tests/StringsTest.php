<?php

namespace OpenSoutheners\LaravelHelpers\Tests;

use function OpenSoutheners\LaravelHelpers\Strings\get_email_domain;
use function OpenSoutheners\LaravelHelpers\Strings\is_json;
use PHPUnit\Framework\TestCase;

class StringsTest extends TestCase
{
    public function test_is_json(): void
    {
        if (version_compare(PHP_VERSION, '8.3', '>')) {
            $this->expectExceptionMessage('is_json function is deprecated. In PHP 8.3+ better use json_validate native function.');
        }

        $this->assertTrue(is_json('{}'));
        $this->assertTrue(is_json('[{}]'));
        $this->assertTrue(is_json('{"foo": "bar"}'));
        $this->assertTrue(is_json('{"foo": "bar"}'));
        $this->assertFalse(is_json("{\u0022foo\u0022: \u0022bar\u0022}"));
        $this->assertFalse(is_json("0"));
        $this->assertFalse(is_json([]));
        $this->assertFalse(is_json(new \stdClass()));
        $this->assertFalse(is_json(1));
    }

    public function test_get_email_domain(): void
    {
        $this->assertEquals('example.org', get_email_domain('test@example.org'));
        $this->assertEquals('', get_email_domain('nope'));
        $this->assertEquals('', get_email_domain('nope@'));
        $this->assertEquals('n', get_email_domain('nope@n'));
    }
}
