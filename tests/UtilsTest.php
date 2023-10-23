<?php

namespace OpenSoutheners\LaravelHelpers\Tests;

use PHPUnit\Framework\TestCase;
use function OpenSoutheners\LaravelHelpers\Utils\parse_http_query;
use function OpenSoutheners\LaravelHelpers\Utils\build_http_query;

class UtilsTest extends TestCase
{
    public function test_parse_http_query()
    {
        $parsedQuery = parse_http_query('filter%5Blabels.id%5D%5B0%5D=1%2C2&filter%5Blabels.id%5D%5B1%5D=4');

        $this->assertIsArray($parsedQuery);
        $this->assertEquals(['filter' => ['labels.id' => ['1,2', '4']]], $parsedQuery);
    }

    public function test_build_http_query()
    {
        $queryString = build_http_query(['filter' => ['labels.id' => [['like' => ['and' => '1,2'], '13'], '4']]]);

        $this->assertIsString($queryString);
        $this->assertEquals('filter%5Blabels.id%5D%5Blike%5D%5Band%5D=1%2C2&filter%5Blabels.id%5D=13&filter%5Blabels.id%5D=4', $queryString);
    }
}
