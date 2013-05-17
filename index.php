<?php

include('class.cws.curl.php');

$cwsCurl = new CwsCurl();
$cwsCurl->setDebugVerbose(CWSCURL_VERBOSE_DEBUG);               // default : CWSCURL_VERBOSE_SIMPLE
$cwsCurl->setUrl("http://www.google.com");                      // The URL to fetch
$cwsCurl->setMethod(CWSCURL_METHOD_GET);                        // HTTP request method ; default CWSCURL_METHOD_GET
//$cwsCurl->addParam("name", "value");                          // Add custom parameters.
//$cwsCurl->addParam("name2", "value2");
$cwsCurl->setTimeout(10);                                       // The maximum number of seconds to allow cURL functions to execute ; default 10
//$cwsCurl->setReferer("http://www.example.com");               // The contents of the "Referer: " header
$cwsCurl->setUserAgent(CWSCURL_UA_FIREFOX);                     // The contents of the "User-Agent: " header ; default CWSCURL_UA_FIREFOX
//$cwsCurl->setAuth("admin", "admin");                          // The username and password for the CURLOPT_USERPWD option
$cwsCurl->setRedirect(true);                                    // Allow redirects ; default true
$cwsCurl->setMaxRedirect(3);                                    // Maximum redirects allowed ; default 3
//$cwsCurl->setProxy("127.0.0.1", 1080, CURLPROXY_SOCKS5);      // Set a HTTP proxy to tunnel requests through.
//$cwsCurl->setProxyAuth("admin", "admin", CURLAUTH_BASIC);     // Set a HTTP proxy authentication.

// Process
$cwsCurl->process();

?>