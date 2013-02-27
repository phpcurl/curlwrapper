<?php
namespace F3\CurlWrapper;
use RuntimeException,
    InvalidArgumentException;

/**
 * OOP wrapper for curl_* functions
 *
 * Functional and OOP style mapping:
 *
 * curl_init($url);             |   $curl = new Curl($url);
 * curl_close($h);              |   unset($curl);
 * $e = curl_errno($h);         |   $e = $curl->errno();
 * $e = curl_error($h);         |   $e = $curl->error();
 * $i = curl_getinfo($h, $o);   |   $i = $curl->getInfo($o);
 * curl_setopt($opt, $val); ;   |   $curl->setOpt($opt, $val);
 * curl_setopt_array($array);   |   $curl->setOptArray($array); or $curl->setOpt($array)
 * curl_version($age)           |   Curl::version($age);
 * $h2 = curl_copy_handle($h);  |   $curl2 = clone($curl);
 * curl_exec($h);               |   $curl->exec();
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
     * @var handler
     */
    private $handle;

    /**
     * Ctor
     *
     * @param string $url URL
     */
    public function __construct($url = null)
    {
        if (func_num_args() > 0)
        {
            $this->handle = curl_init($url);
        }
        else
        {
            $this->handle = curl_init();
        }
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
     * @see curl_error
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
        if ($attempts < 1)
        {
            throw new InvalidArgumentException(sprintf('Attempts count is not positive: %d', $attempts));
        }
        $i = 0;
        while ($i++ < $attempts)
        {
            $result = curl_exec($this->handle);
            if ($result !== false)
            {
                break;
            }
        }
        if ($useException && (false === $result))
        {
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
    public static function version($age = CURLVERSION_NOW)
    {
        return curl_version($age);
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
}
