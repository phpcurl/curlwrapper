<?php
namespace PHPCurl\CurlWrapper;

class CurlShare implements CurlShareInterface
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
        $this->handle = curl_share_init();
    }

    /**
     * @inheritdoc
     */
    public function setOpt(int $opt, $val): bool
    {
        return curl_share_setopt($this->handle, $opt, $val);
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
}
