<?php
namespace PHPCurl\CurlWrapper;

use PHPUnit\Framework\TestCase;

function curl_share_close($h)
{
    CurlShareTest::$log[] = 'close_'.$h;
}

function curl_share_init()
{
    return 'foo';
}

function curl_share_setopt($h, $o, $v)
{
    return $h === 'foo' && $o === 0 && $v === 'val';
}

class CurlShareTest extends TestCase
{
    static public $log = array();

    public function testAll()
    {
        $c = new CurlShare();
        $this->assertTrue($c->setOpt(0, 'val'));
        unset($c);
        $this->assertEquals('close_foo', array_pop(self::$log));
    }
}
