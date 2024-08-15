<?php

namespace OpenSoutheners\ExtendedPhp\Tests;

use PHPUnit\Framework\TestCase;

use function OpenSoutheners\ExtendedPhp\Numbers\short_number;

class NumbersTest extends TestCase
{
    public function test_short_number_format_to_string()
    {
        $this->assertIsString(short_number(1000));
        $this->assertIsString(short_number(1));
    }

    public function test_short_number_format_adding_k_as_suffix_when_thousand_sent()
    {
        $this->assertEquals('1K', short_number(1000));
    }

    public function test_short_number_format_adding_k_as_suffix_when_nearly_thousand_by_rounding_decimals_sent()
    {
        $this->assertEquals('1K', short_number(999.9));
    }

    public function test_short_number_format_adding_m_as_suffix_when_million_sent()
    {
        $this->assertIsString(short_number(1000000));
        $this->assertEquals('1M', short_number(1000000));
    }

    public function test_short_number_format_adding_m_as_suffix_when_billion_sent()
    {
        $this->assertEquals('1000M', short_number(1000000000));
    }

    public function test_short_number_format_to_string_with_no_modifications_when_lower_than_thousand_sent()
    {
        $this->assertIsString(short_number(100));
        $this->assertEquals('100', short_number(100));
    }
}
