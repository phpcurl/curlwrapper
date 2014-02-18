<?php
namespace F3\CurlWrapper;

use F3\Fock\Mocker;

/**
 * @runTestsInSeparateProcesses
 */
class CurlTest extends \PHPUnit_Framework_TestCase
{
    private $m;

    protected function setUp()
    {
        $functions = array(
            'curl_close',
            'curl_copy_handle',
            'curl_errno',
            'curl_error',
            'curl_escape',
            'curl_exec',
            'curl_getinfo',
            'curl_init',
            'curl_pause',
            'curl_reset',
            'curl_setopt',
            'curl_setopt_array',
            'curl_strerror',
            'curl_unescape',
            'curl_version',
        );

        foreach ($functions as $f) {
            $functionsNamespaced[] = __NAMESPACE__.'\\'.$f;
        }

        $this->m = $m = $this->getMock('stdClass', $functions);

        Mocker::mock($functionsNamespaced, function($function, array $args, $namespace, $short) use ($m) {
            return call_user_func_array(array($m, $short), $args);
        });
    }

    protected function tearDown()
    {
        Mocker::clean();
    }

    public function testGeneralMethods()
    {
        $this->m->expects($this->once())
            ->method('curl_init')
            ->with('example.com')
            ->will($this->returnValue('handle'));

        $this->m->expects($this->exactly(2))
            ->method('curl_close')
            ->with($this->logicalOr('handle', 'cloned_handle'));

        $this->m->expects($this->once())
            ->method('curl_copy_handle')
            ->with('handle')
            ->will($this->returnValue('cloned_handle'));

        $this->m->expects($this->once())
            ->method('curl_setopt')
            ->with('handle', 'opt', 'val')
            ->will($this->returnValue('setopt_result'));

        $this->m->expects($this->once())
            ->method('curl_setopt_array')
            ->with('handle', array('foo' => 'bar'))
            ->will($this->returnValue('setopt_array_result'));

        $this->m->expects($this->once())
            ->method('curl_version')
            ->with(42)
            ->will($this->returnValue('version_result'));

        $this->m->expects($this->once())
            ->method('curl_strerror')
            ->with(42)
            ->will($this->returnValue('strerror_result'));

        $this->m->expects($this->once())
            ->method('curl_error')
            ->with('handle')
            ->will($this->returnValue('error_result'));

        $this->m->expects($this->once())
            ->method('curl_errno')
            ->with('handle')
            ->will($this->returnValue('errno_result'));

        $this->m->expects($this->once())
            ->method('curl_getinfo')
            ->with('handle', 42)
            ->will($this->returnValue('info_result'));

        $this->m->expects($this->once())
            ->method('curl_escape')
            ->with('handle', 'str')
            ->will($this->returnValue('escape_result'));

        $this->m->expects($this->once())
            ->method('curl_unescape')
            ->with('handle', 'str')
            ->will($this->returnValue('unescape_result'));

        $this->m->expects($this->once())
            ->method('curl_reset')
            ->with('handle')
            ->will($this->returnValue('reset_result'));

        $this->m->expects($this->once())
            ->method('curl_pause')
            ->with('handle', 42)
            ->will($this->returnValue('pause_result'));

        $curl = new Curl('example.com');
        $this->assertEquals('handle', $curl->getHandle());
        $clone = clone($curl);
        $this->assertEquals('cloned_handle', $clone->getHandle());
        $this->assertEquals('setopt_result', $curl->setOpt('opt', 'val'));
        $this->assertEquals('setopt_array_result', $curl->setOptArray(array('foo' => 'bar')));
        $this->assertEquals('version_result', Curl::version(42));
        $this->assertEquals('strerror_result', Curl::strerror(42));
        $this->assertEquals('error_result', $curl->error());
        $this->assertEquals('errno_result', $curl->errno());
        $this->assertEquals('info_result', $curl->getInfo(42));
        $this->assertEquals('escape_result', $curl->escape('str'));
        $this->assertEquals('unescape_result', $curl->unescape('str'));
        $this->assertEquals('reset_result', $curl->reset());
        $this->assertEquals('pause_result', $curl->pause(42));
    }

    public function testExecDefaultParameters()
    {
        $this->m->expects($this->once())
            ->method('curl_exec')
            ->will($this->returnValue('exec_result'));

        $curl = new Curl('example.com');
        $this->assertEquals('exec_result', $curl->exec());
    }

    public function testExecRetry()
    {
        $this->m->expects($this->exactly(3))
            ->method('curl_exec')
            ->will($this->onConsecutiveCalls(false, false, 'ok'));

        $curl = new Curl();
        $this->assertEquals('ok', $curl->exec(3));
    }

    public function testExecError()
    {
        $this->m->expects($this->exactly(2))
            ->method('curl_exec')
            ->will($this->onConsecutiveCalls(false, false));

        $curl = new Curl();
        $this->assertEquals(false, $curl->exec(2));
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Error "test_error" after 2 attempt(s)
     * @expectedExceptionCode 42
     */
    public function testExecException()
    {
        $this->m->expects($this->exactly(2))
            ->method('curl_exec')
            ->will($this->onConsecutiveCalls(false, false));

        $this->m->expects($this->once())
            ->method('curl_error')
            ->will($this->returnValue('test_error'));

        $this->m->expects($this->once())
            ->method('curl_errno')
            ->will($this->returnValue(42));

        $curl = new Curl();
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
