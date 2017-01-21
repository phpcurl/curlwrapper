<?php
namespace PHPCurl\CurlWrapper;

class Curl
{
    /**
     * @var resource
     */
    private $handle;

    /**
     * @param string $url URL
     */
    public function __construct($url = null)
    {
        $this->init($url);
    }

    /**
     * @see curl_init()
     *
     * @param string $url URL
     * @return void
     */
    public function init($url = null)
    {
        $this->handle = curl_init($url);
    }

    /**
     * @see curl_errno()
     *
     * @return int
     */
    public function errno()
    {
        return curl_errno($this->handle);
    }

    /**
     * @see curl_error()
     *
     * @return string
     */
    public function error()
    {
        return curl_error($this->handle);
    }

    /**
     * @see curl_exec()
     *
     * @return boolean|string
     */
    public function exec()
    {
        return curl_exec($this->handle);
    }

    /**
     * @see curl_getinfo()
     *
     * @param int $opt CURLINFO_*
     * @return array|string
     */
    public function getInfo($opt = 0)
    {
        if (func_num_args() > 0) {
            return curl_getinfo($this->handle, $opt);
        }
        return curl_getinfo($this->handle);
    }

    /**
     * @see curl_setopt()
     *
     * @param int   $option Option code
     * @param mixed $value  Option value
     * @return boolean
     */
    public function setOpt($option, $value)
    {
        return curl_setopt($this->handle, $option, $value);
    }

    /**
     * @see curl_setopt_array()
     *
     * @param array $options Options
     * @return boolean
     */
    public function setOptArray(array $options)
    {
        return curl_setopt_array($this->handle, $options);
    }

    /**
     * @see curl_version()
     *
     * @param int $age
     * @return array
     */
    public function version($age = CURLVERSION_NOW)
    {
        return curl_version($age);
    }

    /**
     * @see curl_strerror()
     *
     * @param int $errornum
     * @return string
     */
    public function strError($errornum)
    {
        return curl_strerror($errornum);
    }

    /**
     * @see curl_escape()
     *
     * @param string $str
     * @return string
     */
    public function escape($str)
    {
        return curl_escape($this->handle, $str);
    }

    /**
     * @see curl_unescape()
     *
     * @param string $str
     * @return string
     */
    public function unescape($str)
    {
        return curl_unescape($this->handle, $str);
    }

    /**
     * @see curl_reset()
     *
     * @return void
     */
    public function reset()
    {
        curl_reset($this->handle);
    }
    /**
     * @see curl_pause()
     *
     * @param int $bitmask
     * @return int
     */
    public function pause($bitmask)
    {
        return curl_pause($this->handle, $bitmask);
    }

    /**
     * Get curl handle
     *
     * @return resource
     */
    public function getHandle()
    {
        return $this->handle;
    }

    public function __destruct()
    {
        curl_close($this->handle);
    }

    public function __clone()
    {
        $this->handle = curl_copy_handle($this->handle);
    }
}
