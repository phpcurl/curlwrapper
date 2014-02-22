<?php
namespace F3\CurlWrapper;

use InvalidArgumentException;
use RuntimeException;

/**
 * OOP wrapper for curl_* functions
 *
 * Functional and OOP style mapping:
 *
 * $h = curl_init($url);              $curl = new Curl($url); //or $curl->init($url)
 * curl_close($h);                    unset($curl);
 * $e = curl_errno($h);               $e = $curl->errno();
 * $e = curl_error($h);               $e = $curl->error();
 * $i = curl_getinfo($h, $opt);       $i = $curl->getInfo($opt);
 * curl_setopt($h, $opt, $val);       $curl->setOpt($opt, $val);
 * curl_setopt_array($h, $array);     $curl->setOptArray($array);
 * curl_version($age)                 Curl::version($age);
 * curl_strerror($errornum)           Curl::strerror($errornum);
 * $h2 = curl_copy_handle($h);        $curl2 = clone($curl);
 * $result = curl_exec($h);           $result = $curl->exec();
 * $res = curl_pause($h, $mask);      $res = $curl->pause($mask);
 * $res = curl_escape($h, $str);      $res = $curl->escape($str);
 * $res = curl_unescape($h, $str);    $res = $curl->unescape($str);
 *
 * @package CurlWrapper
 * @version $id$
 * @copyright Alexey Karapetov
 * @author Alexey Karapetov <karapetov@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php The MIT License (MIT)
 */
class Curl
{
    /**
     * curl handle
     *
     * @var resource
     */
    private $handle;

    /**
     * Ctor
     *
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
     * Get curl handle
     *
     * @return resource
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * @see curl_close()
     *
     * @return void
     */
    public function __destruct()
    {
        curl_close($this->handle);
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
     * @param int $attempts Connection attempts (default is 1)
     * @param boolean $useException Throw \RuntimeException on failure
     * @return boolean|string
     */
    public function exec($attempts = 1, $useException = false)
    {
        $attempts = (int) $attempts;
        if ($attempts < 1) {
            throw new InvalidArgumentException(sprintf('Attempts count is not positive: %d', $attempts));
        }
        $i = 0;
        while ($i++ < $attempts) {
            $result = curl_exec($this->handle);
            if ($result !== false) {
                break;
            }
        }
        if ($useException && (false === $result)) {
            throw new RuntimeException(sprintf('Error "%s" after %d attempt(s)', $this->error(), $attempts), $this->errno());
        }
        return $result;
    }

    /**
     * @see curl_getinfo()
     *
     * @param int $opt CURLINFO_*
     * @return array|string
     */
    public function getInfo($opt = 0)
    {
        return curl_getinfo($this->handle, $opt);
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
    static public function version($age = CURLVERSION_NOW)
    {
        return curl_version($age);
    }

    /**
     * @see curl_strerror()
     *
     * @param int $errornum
     * @return array
     */
    static public function strerror($errornum)
    {
        return curl_strerror($errornum);
    }

    /**
     * __clone
     * Copies handle using curl_copy_handle()
     *
     * @return void
     */
    public function __clone()
    {
        $this->handle = curl_copy_handle($this->handle);
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
        return curl_reset($this->handle);
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
}
