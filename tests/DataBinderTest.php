<?php
namespace TKuni\PhpUrlMetaMapper;

use PHPUnit\Framework\TestCase;

class DataBinderTest extends TestCase
{
    /**
     * @test
     */
    public function canBind()
    {
        $actual = (new DataBinder('aaa{{fizz}}bbb{{foo}}ccc'))->bind([
            'fizz' => 'bazz',
            'foo' => 'bar'
        ]);
        $expect = 'aaabazzbbbbarccc';

        $this->assertEquals($expect, $actual);
    }
}
