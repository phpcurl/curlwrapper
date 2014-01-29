<?php
namespace F3\CurlWrapper;

/**
 * Only some indirect tests are available due to use of system functions.
 *
 * @package CurlWrapper
 * @version $id$
 * @copyright Alexey Karapetov
 * @author Alexey Karapetov <karapetov@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php The MIT License (MIT)
 */
class CurlTest extends \PHPUnit_Framework_TestCase
{
    public function testHandlesShouldBeDifferent()
    {
        $c1 = new Curl();
        $c2 = new Curl();
        $this->assertNotEquals($c1->getHandle(), $c2->getHandle());

        $c3 = clone($c1);
        $this->assertNotEquals($c1->getHandle(), $c3->getHandle());
    }

    public function testSetOptGetInfo()
    {
        $c = new Curl('http://example.com');
        $this->assertEquals('http://example.com', $c->getInfo(CURLINFO_EFFECTIVE_URL));

        $c = new Curl();
        $this->assertEquals(null, $c->getInfo(CURLINFO_EFFECTIVE_URL));
        $c->setOpt(CURLOPT_URL, 'http://foo');
        $this->assertEquals('http://foo', $c->getInfo(CURLINFO_EFFECTIVE_URL));
        $c->setOptArray(array(CURLOPT_URL => 'http://bar'));
        $this->assertEquals('http://bar', $c->getInfo(CURLINFO_EFFECTIVE_URL));
    }

    public function testGetVersion()
    {
        $this->assertEquals(curl_version(), Curl::version());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Attempts count is not positive: -42
     *
     */
    public function testExecInvalidAttemptsCount()
    {
        $c = new Curl();
        $c->exec(-42);
    }

    /**
     * @expectedException RuntimeException
     */
    public function testExecException()
    {
        $c = new Curl();
        $c->exec(1, true);
    }
}
