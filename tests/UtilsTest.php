<?php

namespace OpenSoutheners\ExtendedPhp\Tests;

use PHPUnit\Framework\TestCase;

use function OpenSoutheners\ExtendedPhp\Utils\build_http_query;
use function OpenSoutheners\ExtendedPhp\Utils\parse_http_query;

class UtilsTest extends TestCase
{
    public function test_parse_http_query()
    {
        $parsedQuery = parse_http_query('?filter%5Blabels.id%5D%5Blike%5D%5Band%5D=1%2C2&filter%5Blabels.id%5D%5Blike%5D=13&filter%5Blabels.id%5D=4&sort=-created_at%2Cauthor.name');

        $this->assertIsArray($parsedQuery);
        $this->assertEquals(['filter' => ['labels.id' => ['4', 'like' => ['and' => '1,2', '13']]], 'sort' => '-created_at,author.name'], $parsedQuery);

        $parsedQuery = parse_http_query('');

        $this->assertIsArray($parsedQuery);
        $this->assertEmpty($parsedQuery);
    }

    public function test_build_http_query()
    {
        $queryString = build_http_query(['filter' => ['labels.id' => ['4', 'like' => ['and' => '1,2', '13']]], 'sort' => '-created_at,author.name']);

        $this->assertIsString($queryString);
        $this->assertEquals('?filter%5Blabels.id%5D=4&filter%5Blabels.id%5D%5Blike%5D%5Band%5D=1%2C2&filter%5Blabels.id%5D%5Blike%5D=13&sort=-created_at%2Cauthor.name', $queryString);

        $queryString = build_http_query([]);

        $this->assertIsString($queryString);
        $this->assertEmpty($queryString);
    }
}
