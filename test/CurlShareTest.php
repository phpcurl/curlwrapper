<?php
namespace F3\CurlWrapper;

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
    return 'setopt_'.$h.'_'.$o.'_'.$v;
}

class CurlShareTest extends \PHPUnit_Framework_TestCase
{
    static public $log = array();

    public function testAll()
    {
        $c = new CurlShare();
        $this->assertEquals('setopt_foo_opt_val', $c->setOpt('opt', 'val'));
        unset($c);
        $this->assertEquals('close_foo', array_pop(self::$log));
    }
}
