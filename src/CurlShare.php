<?php
namespace F3\CurlWrapper;

/**
 * OOP wrapper for curl_share_* fuctions
 *
 * Functional to OOP style mapping
 *
 * curl_share_init();                           |   $cs = new CurlShare()
 * curl_share_close($h);                        |   unset($cs);
 * $r = curl_share_setopt($h, $opt, $val);      |   $r = $cs->setOpt($opt, $val);
 *
 * @package CurlWrapper
 * @version $id$
 * @copyright Alexey Karapetov
 * @author Alexey Karapetov <karapetov@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php The MIT License (MIT)
 */
class CurlShare
{
    /**
     * curl handle
     *
     * @var handler
     */
    private $handle;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->handle = curl_share_init();
    }

    /**
     * @see curl_share_close()
     *
     * @return void
     */
    public function __destruct()
    {
        curl_share_close($this->handle);
    }

    /**
     * @see curl_share_setopt
     *
     * @param int $opt
     * @param mixed $val
     * @return boolean
     */
    public function setOpt($opt, $val)
    {
        return curl_share_setopt($this->handle, $opt, $val);
    }
}
