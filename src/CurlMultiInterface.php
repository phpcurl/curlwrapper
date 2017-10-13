<?php
namespace PHPCurl\CurlWrapper;

interface CurlMultiInterface
{
    public function init();

    /**
     * Get handle
     *
     * @return resource
     */
    public function getHandle();

    /**
     * @see curl_multi_add_handle()
     *
     * @param CurlInterface $curl Curl object to add
     * @return int
     */
    public function add(CurlInterface $curl): int;

    /**
     * @see curl_multi_exec()
     *
     * @param int $stillRunning Flag
     * @return int (One of CURLM_* constants)
     */
    public function exec(int &$stillRunning): int;

    /**
     * @see curl_multi_getcontent()
     *
     * @param CurlInterface $curl
     * @return string
     */
    public function getContent(CurlInterface $curl): string;

    /**
     * @see curl_multi_info_read()
     *
     * @param int $msgs
     * @return array
     */
    public function infoRead(int &$msgs = null): array;

    /**
     * @see curl_multi_remove_handle()
     *
     * @param CurlInterface $curl Handle to remove
     * @return int
     */
    public function remove(CurlInterface $curl): int;

    /**
     * @see curl_multi_select()
     *
     * @param float $timeout Timeout
     * @return int
     */
    public function select(float $timeout = 1.0): int;

    /**
     * @see curl_multi_strerror
     *
     * @param int $errornum
     * @return string
     */
    public function strError(int $errornum): string;

    /**
     * @see curl_multi_setopt
     *
     * @param int   $opt
     * @param mixed $val
     * @return boolean
     */
    public function setOpt(int $opt, $val): bool;
}
