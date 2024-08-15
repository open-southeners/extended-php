<?php

namespace OpenSoutheners\ExtendedPhp\Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithDeprecationHandling;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use function OpenSoutheners\ExtendedPhp\Strings\get_email_domain;
use function OpenSoutheners\ExtendedPhp\Strings\is_json;
use function OpenSoutheners\ExtendedPhp\Strings\is_json_structure;
use PHPUnit\Framework\TestCase;
use Throwable;

class StringsTest extends TestCase
{
    use InteractsWithDeprecationHandling;
    use InteractsWithExceptionHandling;

    public function test_is_json(): void
    {
        $assertions = function () {
            $this->assertTrue(is_json('{}'));
            $this->assertTrue(is_json('[{}]'));
            $this->assertTrue(is_json('{"foo": "bar"}'));
            $this->assertTrue(is_json('[{"foo": "bar"}]'));
            $this->assertTrue(is_json('0'));
            $this->assertTrue(is_json('"hello"'));
            $this->assertFalse(is_json("{\u0022foo\u0022: \u0022bar\u0022}"));
            $this->assertFalse(is_json([]));
            $this->assertFalse(is_json(new \stdClass()));
            $this->assertFalse(is_json(1));
        };

        if (version_compare(PHP_VERSION, '8.3', '>')) {
            $this->withoutDeprecationHandling();

            $this->assertThrows(
                $assertions,
                Throwable::class,
                'is_json function is deprecated. In PHP 8.3+ better use json_validate native function.'
            );
        } else {
            $assertions();
        }
    }

    public function test_is_json_structure()
    {
        $this->withoutDeprecationHandling();

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
        $this->assertFalse(is_json_structure(new \stdClass()));
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
