<?php
namespace F3\CurlWrapper;

use F3\Fock\Mocker;

/**
 * @runTestsInSeparateProcesses
 */
class CurlShareTest extends \PHPUnit_Framework_TestCase
{
    private $m;

    protected function setUp()
    {
        $functions = array(
            'curl_share_close',
            'curl_share_init',
            'curl_share_setopt',
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
            ->method('curl_share_init')
            ->will($this->returnValue('handle'));

        $this->m->expects($this->once())
            ->method('curl_share_setopt')
            ->with('handle', 'opt', 'val')
            ->will($this->returnValue('result'));

        $this->m->expects($this->once())
            ->method('curl_share_close')
            ->with('handle');

        $c = new CurlShare();
        $this->assertEquals('result', $c->setOpt('opt', 'val'));
    }
}
