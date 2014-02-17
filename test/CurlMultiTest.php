<?php
namespace F3\CurlWrapper;

/**
 * CurlMultiTest
 *
 * @package CurlWrapper
 * @version $id$
 * @copyright Alexey Karapetov
 * @author Alexey Karapetov <karapetov@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php The MIT License (MIT)
 */
class CurlMultiTest
    extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $m = new CurlMulti();
    }
}
