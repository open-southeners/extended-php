<?php

namespace OpenSoutheners\LaravelHelpers\Tests;

use PHPUnit\Framework\TestCase;

use function OpenSoutheners\LaravelHelpers\Numbers\short_number;

class NumbersTest extends TestCase
{
    public function test_short_number_format_to_string_with_k_when_thousands_sent()
    {
        $this->assertIsString(short_number(1000));
        $this->assertEquals('1K', short_number(1000));
    }

    public function test_short_number_format_to_string_with_m_when_millions_sent()
    {
        $this->assertIsString(short_number(1000000));
        $this->assertEquals('1M', short_number(1000000));
    }

    public function test_short_number_format_to_string_with_no_modifications_when_lower_than_thousand_sent()
    {
        $this->assertIsString(short_number(100));
        $this->assertEquals('100', short_number(100));
    }
}
