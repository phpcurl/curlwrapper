<?php declare(strict_types=1);

namespace PHPCurl\CurlWrapper;

interface CurlInterface
{
    /**
     * @see curl_init()
     *
     * @param string $url URL
     * @return void
     */
    public function init(string $url = null);

    /**
     * @see curl_errno()
     *
     * @return int
     */
    public function errno(): int;

    /**
     * @see curl_error()
     *
     * @return string
     */
    public function error(): string;

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
    public function getInfo(int $opt = 0);

    /**
     * @see curl_setopt()
     *
     * @param int $option Option code
     * @param mixed $value Option value
     * @return boolean
     */
    public function setOpt(int $option, $value): bool;

    /**
     * @see curl_setopt_array()
     *
     * @param array $options Options
     * @return boolean
     */
    public function setOptArray(array $options): bool;

    /**
     * @see curl_version()
     *
     * @param int $age
     * @return array
     */
    public function version(int $age = CURLVERSION_NOW): array;

    /**
     * @see curl_strerror()
     *
     * @param int $errornum
     * @return string
     */
    public function strError(int $errornum): ?string;

    /**
     * @see curl_escape()
     *
     * @param string $str
     * @return string|false
     */
    public function escape(string $str);

    /**
     * @see curl_unescape()
     *
     * @param string $str
     * @return string|false
     */
    public function unescape(string $str);

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
    public function pause(int $bitmask): int;

    /**
     * Get curl handle
     *
     * @return resource
     */
    public function getHandle();
}
