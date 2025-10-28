<?php

namespace OpenSoutheners\ExtendedPhp\Tests;

use PHPUnit\Framework\TestCase;

use function OpenSoutheners\ExtendedPhp\Strings\get_email_domain;
use function OpenSoutheners\ExtendedPhp\Strings\is_json;
use function OpenSoutheners\ExtendedPhp\Strings\is_json_structure;

class StringsTest extends TestCase
{
    public function test_is_json(): void
    {
        $this->assertTrue(is_json('{}'));
        $this->assertTrue(is_json('[{}]'));
        $this->assertTrue(is_json('{"foo": "bar"}'));
        $this->assertTrue(is_json('[{"foo": "bar"}]'));
        $this->assertTrue(is_json('0'));
        $this->assertTrue(is_json('"hello"'));
        $this->assertFalse(is_json("{\u0022foo\u0022: \u0022bar\u0022}"));
        $this->assertFalse(is_json([]));
        $this->assertFalse(is_json(new \stdClass));
        $this->assertFalse(is_json(1));
    }

    public function test_is_json_structure()
    {
        $this->assertTrue(is_json_structure('{}'));
        $this->assertTrue(is_json_structure('[{}]'));
        $this->assertTrue(is_json_structure('{"foo": "bar"}'));
        $this->assertTrue(is_json_structure('[{"foo": "bar"}]'));
        $this->assertFalse(is_json_structure('{"foo": "bar"]'));
        $this->assertFalse(is_json_structure('[{"foo": "bar"]]'));
        $this->assertFalse(is_json_structure('0'));
        $this->assertFalse(is_json_structure('"hello"'));
        $this->assertFalse(is_json_structure("{\u0022foo\u0022: \u0022bar\u0022}"));
        $this->assertFalse(is_json_structure([]));
        $this->assertFalse(is_json_structure(new \stdClass));
        $this->assertFalse(is_json_structure(1));
    }

    public function test_get_email_domain(): void
    {
        $this->assertEquals('example.org', get_email_domain('test@example.org'));
        $this->assertEquals('', get_email_domain('nope'));
        $this->assertEquals('', get_email_domain('nope@'));
        $this->assertEquals('n', get_email_domain('nope@n'));
    }
}
