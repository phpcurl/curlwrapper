<?php
namespace PHPCurl\CurlWrapper;

class Curl implements CurlInterface
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
     * @inheritdoc
     */
    public function init($url = null)
    {
        $this->handle = curl_init($url);
    }

    /**
     * @inheritdoc
     */
    public function errno()
    {
        return curl_errno($this->handle);
    }

    /**
     * @inheritdoc
     */
    public function error()
    {
        return curl_error($this->handle);
    }

    /**
     * @inheritdoc
     */
    public function exec()
    {
        return curl_exec($this->handle);
    }

    /**
     * @inheritdoc
     */
    public function getInfo($opt = 0)
    {
        if (func_num_args() > 0) {
            return curl_getinfo($this->handle, $opt);
        }
        return curl_getinfo($this->handle);
    }

    /**
     * @inheritdoc
     */
    public function setOpt($option, $value)
    {
        return curl_setopt($this->handle, $option, $value);
    }

    /**
     * @inheritdoc
     */
    public function setOptArray(array $options)
    {
        return curl_setopt_array($this->handle, $options);
    }

    /**
     * @inheritdoc
     */
    public function version($age = CURLVERSION_NOW)
    {
        return curl_version($age);
    }

    /**
     * @inheritdoc
     */
    public function strError($errornum)
    {
        return curl_strerror($errornum);
    }

    /**
     * @inheritdoc
     */
    public function escape($str)
    {
        return curl_escape($this->handle, $str);
    }

    /**
     * @inheritdoc
     */
    public function unescape($str)
    {
        return curl_unescape($this->handle, $str);
    }

    /**
     * @inheritdoc
     */
    public function reset()
    {
        curl_reset($this->handle);
    }

    /**
     * @inheritdoc
     */
    public function pause($bitmask)
    {
        return curl_pause($this->handle, $bitmask);
    }

    /**
     * @inheritdoc
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
