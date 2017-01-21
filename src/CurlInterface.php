<?php
namespace PHPCurl\CurlWrapper;

interface CurlInterface
{
    /**
     * @see curl_init()
     *
     * @param string $url URL
     * @return void
     */
    public function init($url = null);

    /**
     * @see curl_errno()
     *
     * @return int
     */
    public function errno();

    /**
     * @see curl_error()
     *
     * @return string
     */
    public function error();

    /**
     * @see curl_exec()
     *
     * @return boolean|string
     */
    public function exec();

    /**
     * @see curl_getinfo()
     *
     * @param int $opt CURLINFO_*
     * @return array|string
     */
    public function getInfo($opt = 0);

    /**
     * @see curl_setopt()
     *
     * @param int   $option Option code
     * @param mixed $value  Option value
     * @return boolean
     */
    public function setOpt($option, $value);

    /**
     * @see curl_setopt_array()
     *
     * @param array $options Options
     * @return boolean
     */
    public function setOptArray(array $options);

    /**
     * @see curl_version()
     *
     * @param int $age
     * @return array
     */
    public function version($age = CURLVERSION_NOW);

    /**
     * @see curl_strerror()
     *
     * @param int $errornum
     * @return string
     */
    public function strError($errornum);

    /**
     * @see curl_escape()
     *
     * @param string $str
     * @return string
     */
    public function escape($str);

    /**
     * @see curl_unescape()
     *
     * @param string $str
     * @return string
     */
    public function unescape($str);

    /**
     * @see curl_reset()
     *
     * @return void
     */
    public function reset();

    /**
     * @see curl_pause()
     *
     * @param int $bitmask
     * @return int
     */
    public function pause($bitmask);

    /**
     * Get curl handle
     *
     * @return resource
     */
    public function getHandle();
}
