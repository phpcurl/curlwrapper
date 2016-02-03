<?php
namespace PHPCurl\CurlWrapper;

function curl_multi_init()
{
    return 'foo';
}

function curl_multi_setopt($h, $o, $v)
{
    return 'setopt_'.$h.'_'.$o.'_'.$v;
}

function curl_multi_add_handle($h, $c)
{
    return 'add_handle_'.$h.'_'.$c;
}

function curl_multi_remove_handle($h, $c)
{
    return 'remove_handle_'.$h.'_'.$c;
}

function curl_multi_getcontent($h)
{
    return 'getcontent_'.$h;
}

function curl_multi_strerror($c)
{
    return 'strerror_'.$c;
}

function curl_multi_select($h, $t)
{
    return 'select_'.$h.'_'.$t;
}

function curl_multi_close($h)
{
    CurlMultiTest::$log[] = 'close_'.$h;
}

function curl_multi_info_read($h, &$m)
{
    $m = 42;
    return 'info_read_'.$h;
}

function curl_multi_exec($h, &$r)
{
    $r = 24;
    return 'exec_'.$h;
}

class CurlMultiTest extends \PHPUnit_Framework_TestCase
{
    static public $log = array();

    public function testAll()
    {
        $c = $this->getMock('PHPCurl\\CurlWrapper\\Curl', array('getHandle'));
        $c->expects($this->any())
            ->method('getHandle')
            ->will($this->returnValue('bar'));

        $cm = new CurlMulti();
        $this->assertEquals('foo', $cm->getHandle());
        $this->assertEquals('setopt_foo_opt_val', $cm->setOpt('opt', 'val'));
        $this->assertEquals('add_handle_foo_bar', $cm->add($c));
        $this->assertEquals('remove_handle_foo_bar', $cm->remove($c));
        $this->assertEquals('getcontent_bar', $cm->getContent($c));
        $this->assertEquals('select_foo_1', $cm->select());
        $this->assertEquals('select_foo_2.3', $cm->select(2.3));

        $this->assertEquals('info_read_foo', $cm->infoRead($msgs));
        $this->assertEquals(42, $msgs);

        $this->assertEquals('exec_foo', $cm->exec($running));
        $this->assertEquals(24, $running);

        $this->assertEquals('strerror_boo', CurlMulti::strerror('boo'));
        unset($cm);
        $this->assertEquals('close_foo', array_pop(self::$log));
    }
}
