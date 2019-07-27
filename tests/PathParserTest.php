<?php
use PHPUnit\Framework\TestCase;

class PathParserTest extends TestCase
{
    /**
     * @var PathParser
     */
    private $parser;

    public function setUp(): void
    {
        parent::setUp();

        $this->parser = new PathParser();
    }

    /**
     * @test
     */
    public function canParseSimpleText()
    {
        $actual = $this->parser->parse('/foo');
        $expect = '|^/foo$|';

        $this->assertEquals($expect, $actual);
    }

    /**
     * @test
     */
    public function canParseRouteParameters()
    {
        $actual = $this->parser->parse('/foo/{id1}/bar/{id2}');
        $expect = '|^/foo/([^/]*)/bar/([^/]*)$|';

        $this->assertEquals($expect, $actual);
    }
}
