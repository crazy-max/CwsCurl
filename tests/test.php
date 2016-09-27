<?php

require_once __DIR__.'/../vendor/autoload.php'; // Autoload files using Composer autoload

$cwsDebug = new Cws\CwsDebug();
$cwsDebug->setDebugVerbose();
$cwsDebug->setEchoMode();

// Start CwsCurl
$cwsCurl = new Cws\CwsCurl($cwsDebug);
$cwsCurl->setUrl('https://www.google.com'); // The URL to fetch
$cwsCurl->setGetMethod(); // HTTP request method ; default METHOD_GET
//$cwsCurl->setPostMethod();
//$cwsCurl->addParam("name", "value"); // Add custom parameters.
//$cwsCurl->addParam("name2", "value2");
//$cwsCurl->addOption(CURLOPT_SSL_VERIFYPEER, true); // Add an option for the cURL transfer.
//$cwsCurl->addOption(CURLOPT_ENCODING, "identity");
$cwsCurl->setTimeout(10); // The maximum number of seconds to allow cURL functions to execute ; default 10
//$cwsCurl->setReferer("http://www.example.com"); // The contents of the "Referer: " header
$cwsCurl->setFirefoxUserAgent(); // The contents of the "User-Agent: " header ; default UA_FIREFOX
//$cwsCurl->setUserAgent('Mozilla/5.0 (Windows NT 6.3; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0');
//$cwsCurl->setAuth("admin", "admin"); // The username and password for the CURLOPT_USERPWD option
$cwsCurl->setRedirect(true); // Allow redirects ; default true
$cwsCurl->setMaxRedirect(3); // Maximum redirects allowed ; default 3
//$cwsCurl->setProxy("127.0.0.1", 1080, CURLPROXY_SOCKS5); // Set a HTTP proxy to tunnel requests through.
//$cwsCurl->setProxyAuth("admin", "admin", CURLAUTH_BASIC); // Set a HTTP proxy authentication.

// Process
$cwsCurl->process();
