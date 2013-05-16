CwsCurl
=======

CwsCurl is a flexible wrapper PHP class for the cURL extension.

Installation
------------

* Enable the [php_curl](http://php.net/manual/en/book.curl.php) extension.
* Copy the ``class.cws.curl.php`` file in a folder on your server.
* Go to ``index.php`` to see an example.

Methods
-------

* **setDebugVerbose** - Control the debug output.
* **setUrl** - The URL to fetch.
* **setMethod** - HTTP request method. (can be CWSCURL_METHOD_DELETE ; CWSCURL_METHOD_GET ; CWSCURL_METHOD_HEAD ; CWSCURL_METHOD_POST ; CWSCURL_METHOD_PUT)
* **addParam** - Add custom parameters to the cURL request.
* **setTimeout** - The maximum number of seconds to allow cURL functions to execute.
* **setReferer** - The contents of the "Referer: " header to be used in a HTTP request.
* **setUserAgent** - The contents of the "User-Agent: " header to be used in a HTTP request. (can be CWSCURL_UA_CHROME ; CWSCURL_UA_FIREFOX ; CWSCURL_UA_GOOGLEBOT ; CWSCURL_UA_IE ; CWSCURL_UA_OPERA)
* **setAuth** - Set authentication to the cURL request with username and password.
* **setRedirect** - Allow redirects.
* **setMaxRedirect** - Maximum redirects allowed.

* **process** - Start the cURL request.

* **getSession** - The current cURL session.
* **getStatus** - The HTTP status code returned.
* **getContent** - The content transfered.
* **getInfos** - The cURL information regarding the transfer.
* **getHeaderFulltext** - The header fulltext response.
* **getHeaders** - The headers response.
