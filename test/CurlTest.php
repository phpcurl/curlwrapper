<?php
namespace PHPCurl\CurlWrapper;

function curl_close($h)
{
    CurlTest::$log[] = [__FUNCTION__, func_get_args()];
}

function curl_init($url)
{
    CurlTest::$log[] = [__FUNCTION__, func_get_args()];
    return 'my_handle';
}

function curl_setopt($h, $o, $v)
{
    CurlTest::$log[] = [__FUNCTION__, func_get_args()];
    return true;
}

function curl_setopt_array($h, $a)
{
    CurlTest::$log[] = [__FUNCTION__, func_get_args()];
    return true;
}

function curl_copy_handle($h)
{
    CurlTest::$log[] = [__FUNCTION__, func_get_args()];
    return "{$h}_copy";
}

function curl_version($v)
{
    CurlTest::$log[] = [__FUNCTION__, func_get_args()];
    return [123];
}

function curl_reset($h)
{
    CurlTest::$log[] = [__FUNCTION__, func_get_args()];
}

function curl_strerror($c)
{
    CurlTest::$log[] = [__FUNCTION__, func_get_args()];
    return 'my_strerror';
}

function curl_escape($v, $s)
{
    CurlTest::$log[] = [__FUNCTION__, func_get_args()];
    return "escaped_{$s}";
}

function curl_unescape($v, $s)
{
    CurlTest::$log[] = [__FUNCTION__, func_get_args()];
    return "unescaped_{$s}";
}

function curl_getinfo($h, $o = null)
{
    CurlTest::$log[] = [__FUNCTION__, func_get_args()];
    return 'my_info';
}

function curl_pause($h, $m)
{
    CurlTest::$log[] = [__FUNCTION__, func_get_args()];
    return 66;
}

function curl_exec($h)
{
    CurlTest::$log[] = [__FUNCTION__, func_get_args()];
}

function curl_error($h)
{
    CurlTest::$log[] = [__FUNCTION__, func_get_args()];
    return 'my_error';
}

function curl_errno($h)
{
    CurlTest::$log[] = [__FUNCTION__, func_get_args()];
    return 42;
}

class CurlTest extends \PHPUnit_Framework_TestCase
{
    static public $log = [];

    public function testAll()
    {
        $c = new Curl('http://example.com');
        $this->assertEquals('my_handle', $c->getHandle());
        $this->assertEquals([123], $c->version());
        $this->assertEquals('my_strerror', $c->strError(5));
        $this->assertEquals('escaped_foo', $c->escape('foo'));
        $this->assertEquals('unescaped_foo', $c->unescape('foo'));
        $this->assertEquals('my_info', $c->getInfo());
        $this->assertEquals('my_info', $c->getInfo(42));
        $this->assertEquals('my_error', $c->error());
        $this->assertEquals(42, $c->errno());
        $this->assertEquals(66, $c->pause(6));
        $c->setOpt(42, true);
        $c->setOptArray([42 => true]);
        $c->exec();
        $c->reset();
        unset($c);

        $this->assertEquals(
            [
                [
                    'PHPCurl\\CurlWrapper\\curl_init',
                    ['http://example.com'],
                ],
                [
                    'PHPCurl\\CurlWrapper\\curl_version',
                    [3],
                ],
                [
                    'PHPCurl\\CurlWrapper\\curl_strerror',
                    [5],
                ],
                [
                    'PHPCurl\\CurlWrapper\\curl_escape',
                    ['my_handle', 'foo'],
                ],
                [
                    'PHPCurl\\CurlWrapper\\curl_unescape',
                    ['my_handle', 'foo'],
                ],
                [
                    'PHPCurl\\CurlWrapper\\curl_getinfo',
                    ['my_handle'],
                ],
                [
                    'PHPCurl\\CurlWrapper\\curl_getinfo',
                    ['my_handle', 42],
                ],
                [
                    'PHPCurl\\CurlWrapper\\curl_error',
                    ['my_handle'],
                ],
                [
                    'PHPCurl\\CurlWrapper\\curl_errno',
                    ['my_handle'],
                ],
                [
                    'PHPCurl\\CurlWrapper\\curl_pause',
                    ['my_handle', 6],
                ],
                [
                    'PHPCurl\\CurlWrapper\\curl_setopt',
                    ['my_handle', 42, true],
                ],
                [
                    'PHPCurl\\CurlWrapper\\curl_setopt_array',
                    ['my_handle', [42 => true]],
                ],
                [
                    'PHPCurl\\CurlWrapper\\curl_exec',
                    ['my_handle'],
                ],
                [
                    'PHPCurl\\CurlWrapper\\curl_reset',
                    ['my_handle'],
                ],
                [
                    'PHPCurl\\CurlWrapper\\curl_close',
                    ['my_handle'],
                ],
            ],
            self::$log
        );
    }

    public function testClone()
    {
        $c = new Curl('http://example.com');
        $clone = clone($c);
        $this->assertEquals('my_handle_copy', $clone->getHandle());
    }
}
