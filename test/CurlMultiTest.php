<?php

namespace PHPCurl\CurlWrapper;

function curl_multi_init()
{
    return 'foo';
}

function curl_multi_setopt($h, $o, $v)
{
    return $h === 'foo' && $o === 0 && $v === 'val';
}

function curl_multi_add_handle($h, $c)
{
    return ($h === 'foo' && $c === 'bar') ? 1 : 0;
}

function curl_multi_remove_handle($h, $c)
{
    return ($h === 'foo' && $c === 'bar') ? 1 : 0;
}

function curl_multi_getcontent($h)
{
    return $h;
}

function curl_multi_strerror($c)
{
    return 'strerror_' . $c;
}

function curl_multi_select($h, $t)
{
    return $h === 'foo' ? $t : 0.0;
}

function curl_multi_close($h)
{
    CurlMultiTest::$log[] = 'close_' . $h;
}

function curl_multi_info_read($h, &$m)
{
    $m = 42;
    return [$h => $m];
}

function curl_multi_exec($h, &$r)
{
    $r = 24;
    return $h === 'foo' ? 1 : 0;
}

class CurlMultiTest extends \PHPUnit_Framework_TestCase
{
    static public $log = [];

    public function testAll()
    {
        $c = $this->getMockForAbstractClass(CurlInterface::class);
        $c->expects($this->any())
            ->method('getHandle')
            ->will($this->returnValue('bar'));

        $cm = new CurlMulti();
        $this->assertEquals('foo', $cm->getHandle());
        $this->assertTrue($cm->setOpt(0, 'val'));
        $this->assertEquals(1, $cm->add($c));
        $this->assertEquals(1, $cm->remove($c));
        $this->assertEquals('bar', $cm->getContent($c));
        $this->assertEquals(1, $cm->select());
        $this->assertEquals(2, $cm->select(2.3));
        $this->assertEquals(['foo' => 42], $cm->infoRead($msgs));
        $this->assertEquals(42, $msgs);
        $running = 0;
        $this->assertEquals(1, $cm->exec($running));
        $this->assertEquals(24, $running);
        $this->assertEquals('strerror_1', $cm->strError(1));
        unset($cm);
        $this->assertEquals('close_foo', array_pop(self::$log));
    }
}
