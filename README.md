#CurlWrapper

The simplest OOP-style wrapper for the standard php curl functions.
The main purpose is to make code that uses curl calls testable. We do it by injecting the Curl object as a dependency instead of calling curl functions directly.


```php
//Not testabe code. Hard-coded dependencies.
class MyApiClient {
    ...
    function call($url)
    {
        $ch = curl_init($url);
        curl_set_opt($ch, ...)
        return curl_exec($ch);
    }
}


//Testable code. Curl object is injected, so can be easily mocked in PHPUnit.
class MyApiClient {

    private $curl;

    function __construct(\F3\CurlWrapper\Curl $curl)
    {
        $this->curl = $curl;
    }

    ...
    function call($url)
    {
        $this->curl->init($url);
        $this->curl->setOpt(...)
        return $this->curl->exec($ch);
    }
}
```


##Basic usage examples

Functional to OOP style mapping

| Functional                        | OOP |
| ---                               | --- |
| `$h = curl_init($url);`           | `$curl = new \F3\CurlWrapper\Curl($url);` |
| `curl_close($h);`                 | `unset($curl);` |
| `$e = curl_errno($h);`            | `$e = $curl->errno();` |
| `$e = curl_error($h);`            | `$e = $curl->error();` |
| `$i = curl_getinfo($h, $opt);`    | `$i = $curl->getInfo($opt);` |
| `curl_setopt($h, $opt, $val);`    | `$curl->setOpt($opt, $val);` |
| `curl_setopt_array($h, $array);`  | `$curl->setOptArray($array);` |
| `curl_version($age)`              | `\F3\CurlWrapper\Curl::version($age);` |
| `$h2 = curl_copy_handle($h);`     | `$curl2 = clone($curl);` |
| `$result = curl_exec($h);`        | `$result = $curl->exec();` |
