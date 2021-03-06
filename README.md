[![Latest Stable Version](https://img.shields.io/packagist/v/crazy-max/cws-curl.svg?style=flat-square)](https://packagist.org/packages/crazy-max/cws-curl)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.3.0-8892BF.svg?style=flat-square)](https://php.net/)
[![Build Status](https://img.shields.io/travis/com/crazy-max/CwsCurl/master.svg?style=flat-square)](https://travis-ci.com/crazy-max/CwsCurl)
[![Code Quality](https://img.shields.io/codacy/grade/bf248165410141b0a323d9ac9fe49248.svg?style=flat-square)](https://www.codacy.com/app/crazy-max/CwsCurl)
[![Become a sponsor](https://img.shields.io/badge/sponsor-crazy--max-181717.svg?logo=github&style=flat-square)](https://github.com/sponsors/crazy-max)
[![Donate Paypal](https://img.shields.io/badge/donate-paypal-00457c.svg?logo=paypal&style=flat-square)](https://www.paypal.me/crazyws)

## :warning: Abandoned project

This project is not maintained anymore and is abandoned. Feel free to fork and make your own changes if needed.

Thanks to everyone for their valuable feedback and contributions.

## About

A flexible wrapper PHP class for the cURL extension.

## Installation

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

![](.res/example.png)

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

## How can I help ?

All kinds of contributions are welcome :raised_hands:! The most basic way to show your support is to star :star2: the project, or to raise issues :speech_balloon: You can also support this project by [**becoming a sponsor on GitHub**](https://github.com/sponsors/crazy-max) :clap: or by making a [Paypal donation](https://www.paypal.me/crazyws) to ensure this journey continues indefinitely! :rocket:

Thanks again for your support, it is much appreciated! :pray:

## License

MIT. See `LICENSE` for more details.
