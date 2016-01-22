<?php
namespace F3\CurlWrapper;

function curl_close($h)
{
    CurlTest::$log[] = 'close_'.$h;
}

function curl_init($url)
{
    return $url;
}

function curl_setopt($h, $o, $v)
{
    return 'setopt_'.$h.'_'.$o.'_'.$v;
}

function curl_setopt_array($h, $a)
{
    return 'setopt_array_'.$h.'_'.implode('_', array_keys($a)).'_'.implode('_', $a);
}

function curl_copy_handle($h)
{
    return 'copy_'.$h;
}

function curl_version($v)
{
    return 'version_'.$v;
}

function curl_reset($h)
{
    CurlTest::$log[] = 'reset_'.$h;
}

function curl_strerror($c)
{
    return 'strerror_'.$c;
}

function curl_escape($v, $s)
{
    return 'escape_'.$v.'_'.$s;
}

function curl_unescape($v, $s)
{
    return 'unescape_'.$v.'_'.$s;
}

function curl_getinfo($h, $o)
{
    return 'getinfo_'.$h.'_'.$o;
}

function curl_pause($h, $m)
{
    return 'pause_'.$h.'_'.$m;
}

function curl_exec($h)
{
    return CurlTest::$mock->exec($h);
}

function curl_error($h)
{
    return CurlTest::$mock->error($h);
}

function curl_errno($h)
{
    return CurlTest::$mock->errno($h);
}

class CurlTest extends \PHPUnit_Framework_TestCase
{
    static public $log = [];
    static public $mock;

    public function setUp()
    {
        self::$mock = $this->getMock('stdClass', ['exec', 'error', 'errno', 'reset']);
    }

    public function testAll()
    {
        $empty = new Curl();
        $this->assertNull($empty->getHandle());

        $c = new Curl('foo');

        $this->assertEquals('setopt_foo_opt_val', $c->setOpt('opt', 'val'));

        $this->assertEquals('setopt_array_foo_0_1_a_b', $c->setOptArray(['a', 'b']));

        $this->assertEquals('foo', $c->getHandle());

        $this->assertEquals('escape_foo_str', $c->escape('str'));

        $this->assertEquals('unescape_foo_str', $c->unescape('str'));

        $c->reset();
        $this->assertEquals('reset_foo', array_pop(self::$log));

        $this->assertEquals('getinfo_foo_0', $c->getinfo());
        $this->assertEquals('getinfo_foo_42', $c->getinfo(42));

        $this->assertEquals('pause_foo_42', $c->pause(42));

        $clone = clone($c);
        $this->assertEquals('copy_foo', $clone->getHandle());

        unset($c);
        $this->assertEquals('close_foo', array_pop(self::$log));

        $this->assertEquals('version_'.CURLVERSION_NOW, Curl::version());
        $this->assertEquals('version_123', Curl::version(123));

        $this->assertEquals('strerror_boo', Curl::strerror('boo'));
    }


    public function testExecDefaultParameters()
    {
        self::$mock->expects($this->once())
            ->method('exec')
            ->will($this->returnValue('result'));

        $curl = new Curl();
        $this->assertEquals('result', $curl->exec());
    }

    public function testExecRetry()
    {
        self::$mock->expects($this->exactly(3))
            ->method('exec')
            ->will($this->onConsecutiveCalls(false, false, 'ok'));

        $curl = new Curl();
        $this->assertEquals('ok', $curl->exec(3));
    }

    public function testExecError()
    {
        self::$mock->expects($this->exactly(2))
            ->method('exec')
            ->will($this->onConsecutiveCalls(false, false));

        $curl = new Curl();
        $this->assertEquals(false, $curl->exec(2));
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Error "omfg" after 2 attempt(s)
     * @expectedExceptionCode 666
     */
    public function testExecException()
    {
        self::$mock->expects($this->exactly(2))
            ->method('exec')
            ->will($this->onConsecutiveCalls(false, false));

        self::$mock->expects($this->once())
            ->method('error')
            ->will($this->returnValue('omfg'));

        self::$mock->expects($this->once())
            ->method('errno')
            ->will($this->returnValue(666));


        $curl = new Curl('zzz');
        $curl->exec(2, true);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Attempts count is not positive: -42
     */
    public function testExecAttemptsNegative()
    {
        $curl = new Curl();
        $curl->exec(-42);
    }
}
