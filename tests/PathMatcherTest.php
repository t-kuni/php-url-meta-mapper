<?php
namespace Tigmium\PhpUrlMetaMapper;

use PHPUnit\Framework\TestCase;

class PathMatcherTest extends TestCase
{
    /**
     * @test
     */
    public function canParseSimpleText()
    {
        $actual = (new PathMatcher('/foo'))->match('/foo');
        $expect = [];

        $this->assertEquals($expect, $actual);
    }

    /**
     * @test
     */
    public function dontMatchDifferentPath()
    {
        $actual = (new PathMatcher('/foo'))->match('/bar');
        $expect = null;

        $this->assertEquals($expect, $actual);
    }

    /**
     * @test
     */
    public function canParseRouteParameters()
    {
        $actual = (new PathMatcher('/foo/{id1}/bar/{id2}'))->match('/foo/1/bar/2');
        $expect = [
            'id1' => "1",
            'id2' => "2",
        ];

        $this->assertEquals($expect, $actual);
    }
}
