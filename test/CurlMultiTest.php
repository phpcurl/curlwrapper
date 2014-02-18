<?php
namespace F3\CurlWrapper;

use F3\Fock\Mocker;

// Function mocks
function curl_multi_exec ($handle, &$stillRunning) {
    $stillRunning = true;
    return 123;
}
function curl_multi_info_read ($handle, &$msgs) {
    $msgs = 'hello';
    return 123;
}

/**
 * @runTestsInSeparateProcesses
 */
class CurlMultiTest extends \PHPUnit_Framework_TestCase
{
    private $m;

    protected function setUp()
    {
        $functions = array(
            'curl_multi_add_handle',
            'curl_multi_close',
            'curl_multi_getcontent',
            'curl_multi_init',
            'curl_multi_remove_handle',
            'curl_multi_select',
            'curl_multi_setopt',
            'curl_multi_strerror',
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
        $c = new Curl();

        $this->m->expects($this->once())
            ->method('curl_multi_init')
            ->will($this->returnValue('handle'));

        $this->m->expects($this->once())
            ->method('curl_multi_close')
            ->with('handle');

        $this->m->expects($this->once())
            ->method('curl_multi_add_handle')
            ->with('handle', $c->getHandle())
            ->will($this->returnValue(42));

        $this->m->expects($this->once())
            ->method('curl_multi_getcontent')
            ->with($c->getHandle())
            ->will($this->returnValue('content'));

        $this->m->expects($this->once())
            ->method('curl_multi_remove_handle')
            ->with('handle', $c->getHandle())
            ->will($this->returnValue(42));

        $this->m->expects($this->once())
            ->method('curl_multi_select')
            ->with('handle', 3.21)
            ->will($this->returnValue(42));

        $this->m->expects($this->once())
            ->method('curl_multi_strerror')
            ->with(222)
            ->will($this->returnValue('my_error'));

        $this->m->expects($this->once())
            ->method('curl_multi_setopt')
            ->with('handle', 'opt', 'val')
            ->will($this->returnValue('result'));

        $cm = new CurlMulti();
        $this->assertEquals('handle', $cm->getHandle());
        $this->assertEquals(42, $cm->add($c));
        $this->assertEquals('content', $cm->getContent($c));
        $this->assertEquals(42, $cm->remove($c));
        $this->assertEquals(42, $cm->select(3.21));
        $this->assertEquals('my_error', CurlMulti::strerror(222));
        $this->assertEquals('result', $cm->setOpt('opt', 'val'));
    }

    public function testExec()
    {
        $cm = new CurlMulti();
        $stillRunning = false;
        $this->assertEquals(123, $cm->exec($stillRunning));
        $this->assertTrue($stillRunning);
    }

    public function testInfoRead()
    {
        $cm = new CurlMulti();
        $msgs = '';
        $this->assertEquals(123, $cm->infoRead($msgs));
        $this->assertEquals('hello', $msgs);
    }
}
