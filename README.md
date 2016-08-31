[![Latest Stable Version](https://img.shields.io/packagist/v/crazy-max/cws-curl.svg?style=flat-square)](https://packagist.org/packages/crazy-max/cws-curl)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.3.0-8892BF.svg?style=flat-square)](https://php.net/)
[![Build Status](https://img.shields.io/travis/crazy-max/CwsCurl/master.svg?style=flat-square)](https://travis-ci.org/crazy-max/CwsCurl)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/crazy-max/CwsCurl.svg?style=flat-square)](https://scrutinizer-ci.com/g/crazy-max/CwsCurl)
[![Gemnasium](https://img.shields.io/gemnasium/crazy-max/CwsCurl.svg?style=flat-square)](https://gemnasium.com/github.com/crazy-max/CwsCurl)

# CwsCurl

A flexible wrapper PHP class for the cURL extension.

## Requirements

* PHP >= 5.3.0
* CwsDebug >= 1.8
* Enable the [php_curl](http://php.net/manual/en/book.curl.php) extension

## Installation with Composer

```bash
composer require crazy-max/cws-curl
```

And download the code:

```bash
composer install # or update
```

## Getting started

See `tests/test.php` file sample to help you.

## Example

![](https://raw.github.com/crazy-max/CwsCurl/master/example.png)

## Methods

**reset** - Reset.<br />
**process** - Start the cURL request.<br />

**getUrl** - The URL to fetch.<br />
**setUrl** - Set the URL to fetch.<br />
**getMethod** - The HTTP request method.<br />
**setDeleteMethod** - Set DELETE HTTP request method.<br />
**setGetMethod** - Set GET HTTP request method. (default)<br />
**setHeadMethod** - Set HEAD HTTP request method.<br />
**setPostMethod** - Set POST HTTP request method.<br />
**setPutMethod** - Set PUT HTTP request method.<br />
**getParams** - Query string parameters.<br />
**addParam** - Add a custom parameter to the cURL request.<br />
**addOption** - Add an option for the cURL transfer.<br />
**getTimeout** - The maximum number of seconds to allow cURL functions to execute.<br />
**setTimeout** - Set the maximum number of seconds to allow cURL functions to execute.<br />
**getReferer** - The contents of the "Referer: " header to be used in a HTTP request.<br />
**setReferer** - Set the contents of the "Referer: " header to be used in a HTTP request.<br />
**getUserAgent** - The contents of the "User-Agent: " header to be used in a HTTP request.<br />
**setChromeUseragent** - Set the Chrome User-Agent to the contents of the "User-Agent: " header to be used in a HTTP request.<br />
**setFirefoxUseragent** - Set the Firefox User-Agent to the contents of the "User-Agent: " header to be used in a HTTP request.<br />
**setGooglebotUseragent** - Set the Googlebot User-Agent to the contents of the "User-Agent: " header to be used in a HTTP request.<br />
**setIeUseragent** - Set the Internet Explorer User-Agent to the contents of the "User-Agent: " header to be used in a HTTP request.<br />
**setOperaUseragent** - Set the Opera User-Agent to the contents of the "User-Agent: " header to be used in a HTTP request.<br />
**setUserAgent** - Set The contents of the "User-Agent: " header to be used in a HTTP request.<br />
**getUsername** - The username for the CURLOPT_USERPWD option.<br />
**getPassword** - The password associated to the username for the CURLOPT_USERPWD option.<br />
**setAuth** - Set authentication to the cURL request with username and password.<br />
**isRedirect** - Redirects allowed.<br />
**setRedirect** - Set allow redirects.<br />
**getMaxRedirect** - Maximum redirects allowed.<br />
**setMaxRedirect** - Set the maximum redirects allowed.<br />
**getProxyHost** - The host IP of the proxy to connect to.<br />
**getProxyPort** - The port number of the proxy to connect to.<br />
**getProxyType** - The proxy type CURLPROXY_HTTP, CURLPROXY_SOCKS4 or CURLPROXY_SOCKS5.<br />
**setProxy** - Set a HTTP proxy to tunnel requests through.<br />
**getProxyAuthType** - The HTTP authentication method(s) to use for the proxy connection. Can be CURLAUTH_BASIC or CURLAUTH_NTLM.<br />
**getProxyUsername** - The username for the CURLOPT_PROXYUSERPWD option.<br />
**getProxyPassword** - The password associated to the proxyUsername for the CURLOPT_PROXYUSERPWD option.<br />
**setProxyAuth** - Set a HTTP proxy authentication.<br /><br />

**getSession** - The current cURL session.<br />
**getStatus** - The HTTP status code returned.<br />
**getContent** - The content transferred.<br />
**getInfos** - The cURL information regarding the transfer.<br />
**getHeaderFulltext** - The header fulltext response.<br />
**getHeaders** - The headers response.<br />
**getError** - Get the last error.<br />

## License

LGPL. See `LICENSE` for more details.

## More infos

http://www.crazyws.fr/dev/classes-php/cwscurl-une-classe-wrapper-pour-extension-curl-php-KLV4G.html
