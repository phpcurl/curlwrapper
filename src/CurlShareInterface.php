<?php declare(strict_types=1);

namespace PHPCurl\CurlWrapper;

interface CurlShareInterface
{
    /**
     * @see curl_share_init()
     *
     * @return void
     */
    public function init();

    /**
     * @see curl_share_setopt()
     *
     * @param int   $opt
     * @param mixed $val
     * @return boolean
     */
    public function setOpt(int $opt, $val): bool;
}
