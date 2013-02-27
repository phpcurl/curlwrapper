<?php
namespace F3\CurlWrapper;

/**
 * OOP wrapper for curl_multi_* fuctions
 *
 * Functional to OOP style mapping
 *
 * curl_multi_init();                           |   $cm = CurlMulti::factory();
 * curl_multi_close($h);                        |   unset($cm);
 * $i = curl_multi_add_handle($mh, $ch);        |   $i = $cm->add($curl);
 * $i = curl_multi_remove_handle($mh, $ch);     |   $i = $cm->remove($curl);
 * $i = curl_multi_exec($mh, $running);         |   $i = $cm->exec($running);
 * $s = curl_multi_getcontent($ch);             |   $s = $cm->getContent($curl);
 * $a = curl_multi_info_read($mh, $msgs);       |   $a = $cm->infoRead($msgs)
 * $i = curl_multi_select($mh, $timeout);       |   $i = $cm->select($timeout);
 *
 * @package CurlWrapper
 * @version $id$
 * @copyright Alexey Karapetov
 * @author Alexey Karapetov <karapetov@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php The MIT License (MIT)
 */
class CurlMulti
{
    /**
     * curl handle
     *
     * @var handler
     */
    private $handle;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->handle = curl_multi_init();
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

    /**
     * @see curl_multi_add_handle()
     *
     * @param Curl $curl Добавляемый объект
     * @return int
     */
    public function add(Curl $curl)
    {
        return curl_multi_add_handle($this->handle, $curl->getHandle());
    }

    /**
     * @see curl_multi_exec()
     *
     * @param int $stillRunning Flag
     * @return int (One of CURLM_* constants)
     */
    public function exec(&$stillRunning)
    {
        return curl_multi_exec($this->handle, $stillRunning);
    }

    /**
     * @see curl_multi_getcontent()
     *
     * @return string
     */
    public function getContent(Curl $curl)
    {
        return curl_multi_getcontent($curl->getHandle());
    }

    /**
     * @see curl_multi_info_read()
     *
     * @param int $msgs
     * @return array
     */
    public function infoRead(&$msgs = null)
    {
        return curl_multi_info_read($this->handle, $msgs);
    }

    /**
     * @see curl_multi_remove_handle()
     *
     * @param Curl $curl Handle to remove
     * @return int
     */
    public function remove(Curl $curl)
    {
        return curl_multi_remove_handle($this->handle, $curl->getHandle());
    }

    /**
     * @see curl_multi_select()
     *
     * @param float $timeout Таймаут блокирования
     * @return int
     */
    public function select($timeout = 1.0)
    {
        return curl_multi_select($this->handle, $timeout);
    }
}
