<?php
namespace PHPCurl\CurlWrapper;

/**
 * OOP wrapper for curl_share_* fuctions
 *
 * Functional to OOP style mapping
 *
 * curl_share_init();                        $cs = new CurlShare()
 * curl_share_close($h);                     unset($cs);
 * $r = curl_share_setopt($h, $opt, $val);   $r = $cs->setOpt($opt, $val);
 *
 * @license http://opensource.org/licenses/mit-license.php The MIT License (MIT)
 */
class CurlShare
{
    /**
     * @var resource
     */
    private $handle;

    public function __construct()
    {
        $this->init();
    }

    /**
     * @see curl_share_init()
     *
     * @return void
     */
    public function init()
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
