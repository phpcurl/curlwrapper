#CurlWrapper

The simplest OOP-style wrapper for php curl functions.


##Basic usage examples

Functional to OOP style mapping

| Functional                        | OOP |
| ---                               | --- |
| `$h =curl_init($url);`            | `$curl = new \F3\CurlWrapper\Curl($url);` |
| `curl_close($h);`                 | `unset($curl);` |
| `$e = curl_errno($h);`            | `$e = $curl->errno();` |
| `$e = curl_error($h);`            | `$e = $curl->error();` |
| `$i = curl_getinfo($h, $o);`      | `$i = $curl->getInfo($o);` |
| `curl_setopt($h, $opt, $val);`    | `$curl->setOpt($opt, $val);` |
| `curl_setopt_array($h, $array);`  | `$curl->setOptArray($array);` |
| `curl_version($age)`              | `\F3\CurlWrapper\Curl::version($age);` |
| `$h2 = curl_copy_handle($h);`     | `$curl2 = clone($curl);` |
| `curl_exec($h);`                  | `$curl->exec();` |
