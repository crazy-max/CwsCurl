CwsCurl
=======

CwsCurl is a flexible wrapper PHP class for the cURL extension.

Installation
------------

* Enable the [php_curl](http://php.net/manual/en/book.curl.php) extension.
* Copy the ``class.cws.curl.php`` file in a folder on your server.
* Go to ``index.php`` to see an example.

Getting started
---------------

```php
<?php

include('class.cws.curl.php');

$cwsCurl = new CwsCurl();
$cwsCurl->setDebugVerbose(CWSCURL_VERBOSE_DEBUG);    // default : CWSCURL_VERBOSE_SIMPLE
$cwsCurl->setUrl("http://www.google.com");           // The URL to fetch
$cwsCurl->setMethod(CWSCURL_METHOD_GET);             // HTTP request method ; default CWSCURL_METHOD_GET
//$cwsCurl->addParam("name", "value");               // Add custom parameters.
//$cwsCurl->addParam("name2", "value2");
$cwsCurl->setTimeout(10);                            // The maximum number of seconds to allow cURL functions to execute ; default 10
//$cwsCurl->setReferer("http://www.example.com");    // The contents of the "Referer: " header
$cwsCurl->setUserAgent(CWSCURL_UA_FIREFOX);          // The contents of the "User-Agent: " header ; default CWSCURL_UA_FIREFOX
//$cwsCurl->setAuth("admin", "admin");               // The username and password for the CURLOPT_USERPWD option
$cwsCurl->setRedirect(true);                         // Allow redirects ; default true
$cwsCurl->setMaxRedirect(3);                         // Maximum redirects allowed ; default 3

// Process
$cwsCurl->process();

?>
```

Methods
-------

**setDebugVerbose** - Control the debug output.<br />
**setUrl** - The URL to fetch.<br />
**setMethod** - HTTP request method. (can be CWSCURL_METHOD_DELETE ; CWSCURL_METHOD_GET ; CWSCURL_METHOD_HEAD ; CWSCURL_METHOD_POST ; CWSCURL_METHOD_PUT)<br />
**addParam** - Add custom parameters to the cURL request.<br />
**setTimeout** - The maximum number of seconds to allow cURL functions to execute.<br />
**setReferer** - The contents of the "Referer: " header to be used in a HTTP request.<br />
**setUserAgent** - The contents of the "User-Agent: " header to be used in a HTTP request. (can be CWSCURL_UA_CHROME ; CWSCURL_UA_FIREFOX ; CWSCURL_UA_GOOGLEBOT ; CWSCURL_UA_IE ; CWSCURL_UA_OPERA)<br />
**setAuth** - Set authentication to the cURL request with username and password.<br />
**setRedirect** - Allow redirects.<br />
**setMaxRedirect** - Maximum redirects allowed.<br />

**process** - Start the cURL request.<br />

**getSession** - The current cURL session.<br />
**getStatus** - The HTTP status code returned.<br />
**getContent** - The content transferred.<br />
**getInfos** - The cURL information regarding the transfer.<br />
**getHeaderFulltext** - The header fulltext response.<br />
**getHeaders** - The headers response.<br />

More infos
----------

http://www.crazyws.fr/dev/classes-php/cwscurl-une-classe-wrapper-pour-extension-curl-php-KLV4G.html