<?php
namespace PHPCurl\CurlWrapper;

class CurlMulti implements CurlMultiInterface
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
     * @inheritdoc
     */
    public function init()
    {
        $this->handle = curl_multi_init();
    }

    /**
     * @inheritdoc
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * @inheritdoc
     */
    public function add(CurlInterface $curl)
    {
        return curl_multi_add_handle($this->handle, $curl->getHandle());
    }

    /**
     * @inheritdoc
     */
    public function exec(&$stillRunning)
    {
        return curl_multi_exec($this->handle, $stillRunning);
    }

    /**
     * @inheritdoc
     */
    public function getContent(CurlInterface $curl)
    {
        return curl_multi_getcontent($curl->getHandle());
    }

    /**
     * @inheritdoc
     */
    public function infoRead(&$msgs = null)
    {
        return curl_multi_info_read($this->handle, $msgs);
    }

    /**
     * @inheritdoc
     */
    public function remove(CurlInterface $curl)
    {
        return curl_multi_remove_handle($this->handle, $curl->getHandle());
    }

    /**
     * @inheritdoc
     */
    public function select($timeout = 1.0)
    {
        return curl_multi_select($this->handle, $timeout);
    }

    /**
     * @inheritdoc
     */
    public function strError($errornum)
    {
        return curl_multi_strerror($errornum);
    }

    /**
     * @inheritdoc
     */
    public function setOpt($opt, $val)
    {
        return curl_multi_setopt($this->handle, $opt, $val);
    }

    /**
     * @see curl_multi_close()
     *
     * @return void
     */
    public function __destruct()
    {
        curl_multi_close($this->handle);
    }
}
