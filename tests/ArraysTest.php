<?php

namespace OpenSoutheners\ExtendedPhp\Tests;

use PHPUnit\Framework\TestCase;

use function OpenSoutheners\ExtendedPhp\Arrays\array_csv;
use function OpenSoutheners\ExtendedPhp\Arrays\array_csv_assoc;
use function OpenSoutheners\ExtendedPhp\Arrays\array_to_csv;

class ArraysTest extends TestCase
{
    public function test_strtocsv(): void
    {
        $csvString = array_to_csv([
            ['name' => 'John Doe', 'employeeId' => '1', 'email' => 'john@example.com'],
            ['name' => 'Jane Doe', 'employeeId' => '2', 'email' => 'jane@example.com'],
            ['name' => 'Bob Smith', 'employeeId' => '3', 'email' => 'bob@example.com'],
        ]);

        $this->assertIsString($csvString);
        $this->assertEquals("name,employeeId,email\nJohn Doe,1,john@example.com\nJane Doe,2,jane@example.com\nBob Smith,3,bob@example.com", $csvString);
    }
    
    public function test_strtocsv_non_associative(): void
    {
        $csvString = array_to_csv([
            ['John Doe', '1', 'john@example.com'],
            ['Jane Doe', '2', 'jane@example.com'],
            ['Bob Smith', '3', 'bob@example.com'],
        ]);

        $this->assertIsString($csvString);
        $this->assertEquals("John Doe,1,john@example.com\nJane Doe,2,jane@example.com\nBob Smith,3,bob@example.com", $csvString);
    }
    
    public function test_strtocsv_with_delimiter(): void
    {
        $csvString = array_to_csv([
            ['name' => 'John Doe', 'employeeId' => '1', 'email' => 'john@example.com'],
            ['name' => 'Jane Doe', 'employeeId' => '2', 'email' => 'jane@example.com'],
            ['name' => 'Bob Smith', 'employeeId' => '3', 'email' => 'bob@example.com'],
        ], ';');

        $this->assertIsString($csvString);
        $this->assertEquals("name;employeeId;email\nJohn Doe;1;john@example.com\nJane Doe;2;jane@example.com\nBob Smith;3;bob@example.com", $csvString);
    }
    
    public function test_array_csv()
    {
        $array = array_csv("hello,world\nfoo,yes\nanother,world\ncontent,Lorem ipsum dolor");

        $this->assertCount(4, $array);

        $this->assertEmpty(array_diff($array[0], [
            'hello', 'world',
        ]));

        $this->assertEmpty(array_diff($array[1], [
            'foo', 'yes',
        ]));

        $this->assertEmpty(array_diff($array[2], [
            'another', 'world',
        ]));

        $this->assertEmpty(array_diff($array[3], [
            'content', 'Lorem ipsum dolor',
        ]));
    }
    
    public function test_array_csv_with_delimiter()
    {
        $array = array_csv("hello;world\nfoo;yes\nanother;world\ncontent;Lorem ipsum dolor", ';');

        $this->assertCount(4, $array);

        $this->assertEmpty(array_diff($array[0], [
            'hello', 'world',
        ]));

        $this->assertEmpty(array_diff($array[1], [
            'foo', 'yes',
        ]));

        $this->assertEmpty(array_diff($array[2], [
            'another', 'world',
        ]));

        $this->assertEmpty(array_diff($array[3], [
            'content', 'Lorem ipsum dolor',
        ]));
    }
    
    public function test_array_csv_assoc()
    {
        $array = array_csv_assoc("key,value\nhello,world\nfoo,yes\nanother,world\ncontent,Lorem ipsum dolor");

        $this->assertCount(4, $array);

        $this->assertEmpty(array_diff($array[0], [
            'key' => 'hello',
            'value' => 'world',
        ]));

        $this->assertEmpty(array_diff($array[1], [
            'key' => 'foo',
            'value' => 'yes',
        ]));

        $this->assertEmpty(array_diff($array[2], [
            'key' => 'another',
            'value' => 'world',
        ]));

        $this->assertEmpty(array_diff($array[3], [
            'key' => 'content',
            'value' => 'Lorem ipsum dolor',
        ]));
    }
}
