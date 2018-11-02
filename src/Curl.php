<?php declare(strict_types=1);

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
    public function __construct(string $url = null)
    {
        $this->init($url);
    }

    /**
     * @inheritdoc
     */
    public function init(string $url = null)
    {
        $this->handle = curl_init($url);
    }

    /**
     * @inheritdoc
     */
    public function errno(): int
    {
        return curl_errno($this->handle);
    }

    /**
     * @inheritdoc
     */
    public function error(): string
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
    public function getInfo(int $opt = 0)
    {
        if (func_num_args() > 0) {
            return curl_getinfo($this->handle, $opt);
        }
        return curl_getinfo($this->handle);
    }

    /**
     * @inheritdoc
     */
    public function setOpt(int $option, $value): bool
    {
        return curl_setopt($this->handle, $option, $value);
    }

    /**
     * @inheritdoc
     */
    public function setOptArray(array $options): bool
    {
        return curl_setopt_array($this->handle, $options);
    }

    /**
     * @inheritdoc
     */
    public function version(int $age = CURLVERSION_NOW): array
    {
        return curl_version($age);
    }

    /**
     * @inheritdoc
     */
    public function strError(int $errornum): ?string
    {
        return curl_strerror($errornum);
    }

    /**
     * @inheritdoc
     */
    public function escape(string $str)
    {
        return curl_escape($this->handle, $str);
    }

    /**
     * @inheritdoc
     */
    public function unescape(string $str)
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
    public function pause(int $bitmask): int
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
