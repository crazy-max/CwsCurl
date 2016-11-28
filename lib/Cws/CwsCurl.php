<?php

/**
 * CwsCurl.
 *
 * A flexible wrapper PHP class for the cURL extension.
 *
 * @author Cr@zy
 * @copyright 2013-2015, Cr@zy
 * @license GNU LESSER GENERAL PUBLIC LICENSE
 *
 * @link https://github.com/crazy-max/CwsCurl
 */
namespace Cws;

class CwsCurl
{
    const METHOD_DELETE = 'DELETE';
    const METHOD_GET = 'GET';
    const METHOD_HEAD = 'HEAD';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';

    const UA_CHROME = 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.872.0 Safari/535.2';
    const UA_FIREFOX = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.9';
    const UA_GOOGLEBOT = 'Googlebot/2.1 ( http://www.googlebot.com/bot.html)';
    const UA_IE = 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0)';
    const UA_OPERA = 'Opera/9.80 (Windows NT 6.1; U; en-US) Presto/2.9.181 Version/12.00';

    /**
     * The URL to fetch.
     *
     * @var string
     */
    private $url;

    /**
     * HTTP request method.
     * default METHOD_GET.
     *
     * @var string
     */
    private $method;

    /**
     * Query string parameters.
     *
     * @var array
     */
    private $params;

    /**
     * List of options for the cURL transfer.
     *
     * @var array
     */
    private $options;

    /**
     * The maximum number of seconds to allow cURL functions to execute.
     * default 10.
     *
     * @var int
     */
    private $timeout;

    /**
     * The contents of the "Referer: " header to be used in a HTTP request.
     *
     * @var string
     */
    private $referer;

    /**
     * The contents of the "User-Agent: " header to be used in a HTTP request.
     * default UA_FIREFOX.
     *
     * @var string
     */
    private $useragent;

    /**
     * The username for the CURLOPT_USERPWD option.
     *
     * @var string
     */
    private $username;

    /**
     * The password associated to the username for the CURLOPT_USERPWD option.
     *
     * @var string
     */
    private $password;

    /**
     * Allow redirects.
     * default true.
     *
     * @var bool
     */
    private $redirect;

    /**
     * Maximum redirects allowed.
     * default 3.
     *
     * @var int
     */
    private $maxRedirect;

    /**
     * The host IP of the proxy to connect to.
     *
     * @var string
     */
    private $proxyHost;

    /**
     * The port number of the proxy to connect to.
     *
     * @var int
     */
    private $proxyPort;

    /**
     * The proxy type CURLPROXY_HTTP, CURLPROXY_SOCKS4 or CURLPROXY_SOCKS5.
     *
     * @var int
     */
    private $proxyType;

    /**
     * The HTTP authentication method(s) to use for the proxy connection.
     * Can be CURLAUTH_BASIC or CURLAUTH_NTLM.
     *
     * @var int
     */
    private $proxyAuthType;

    /**
     * The username for the CURLOPT_PROXYUSERPWD option.
     *
     * @var string
     */
    private $proxyUsername;

    /**
     * The password associated to the proxyUsername for the CURLOPT_PROXYUSERPWD option.
     *
     * @var string
     */
    private $proxyPassword;

    /**
     * The cURL session.
     *
     * @var resource
     */
    private $session;

    /**
     * The HTTP status code returned.
     *
     * @var int
     */
    private $status;

    /**
     * The content transferred.
     *
     * @var string
     */
    private $content;

    /**
     * The cURL information regarding the transfer.
     *
     * @var object
     */
    private $infos;

    /**
     * The header fulltext response.
     *
     * @var string
     */
    private $headerFulltext;

    /**
     * The headers response.
     *
     * @var array
     */
    private $headers;

    /**
     * A temporary token for headers parsing.
     *
     * @var string
     */
    private $headerNextToken;

    /**
     * The last error message.
     *
     * @var string
     */
    private $error;

    /**
     * The cws debug instance.
     *
     * @var CwsDebug
     */
    private $cwsDebug;

    public function __construct(CwsDebug $cwsDebug)
    {
        $this->cwsDebug = $cwsDebug;
        $this->reset();

        if (!in_array('curl', get_loaded_extensions())) {
            $this->error = 'The cURL extension is not loaded...';
            $this->cwsDebug->error($this->error);
            exit();
        }
    }

    /**
     * Reset.
     */
    public function reset()
    {
        $this->url = null;
        $this->method = self::METHOD_GET;
        $this->params = array();
        $this->options = array();
        $this->timeout = 10;
        $this->referer = null;
        $this->useragent = self::UA_FIREFOX;
        $this->username = null;
        $this->password = null;
        $this->username = null;
        $this->redirect = true;
        $this->maxRedirect = 3;
        $this->proxyHost = null;
        $this->proxyPort = null;
        $this->proxyType = null;
        $this->proxyAuthType = null;
        $this->proxyUsername = null;
        $this->proxyPassword = null;
        $this->status = null;
        $this->content = null;
        $this->infos = null;
        $this->headerFulltext = null;
        $this->headers = array();
        $this->error = null;
    }

    /**
     * Start process.
     */
    public function process()
    {
        $this->cwsDebug->titleH2('process', CwsDebug::VERBOSE_SIMPLE);

        $this->session = curl_init();
        curl_setopt($this->session, CURLOPT_NOBODY, false);

        $data = null;
        if (is_array($this->params) && count($this->params) > 0) {
            $data = http_build_query($this->params);
        }

        switch ($this->method) {
            case self::METHOD_DELETE:
                curl_setopt($this->session, CURLOPT_CUSTOMREQUEST, self::METHOD_DELETE);
                break;
            case self::METHOD_GET:
                if ($data !== null) {
                    $this->url = $this->url.'?'.$data;
                }
                curl_setopt($this->session, CURLOPT_HTTPGET, true);
                break;
            case self::METHOD_HEAD:
                curl_setopt($this->session, CURLOPT_NOBODY, true);
               break;
            case self::METHOD_POST:
                if ($data !== null) {
                    curl_setopt($this->session, CURLOPT_POST, true);
                    curl_setopt($this->session, CURLOPT_POSTFIELDS, $data);
                } else {
                    curl_setopt($this->session, CURLOPT_CUSTOMREQUEST, self::METHOD_POST);
                }
                break;
            case self::METHOD_PUT:
                if ($data !== null) {
                    $handle = fopen('php://temp', 'rw+');
                    fwrite($handle, $data);
                    rewind($handle);

                    curl_setopt($this->session, CURLOPT_INFILE, $handle);
                    curl_setopt($this->session, CURLOPT_INFILESIZE, strlen($data));
                    curl_setopt($this->session, CURLOPT_PUT, true);
                } else {
                    curl_setopt($this->session, CURLOPT_CUSTOMREQUEST, self::METHOD_PUT);
                }
                break;
        }

        if ($this->username && $this->password) {
            curl_setopt($this->session, CURLOPT_USERPWD, $this->username.':'.$this->password);
        }

        if ($this->proxyHost && $this->proxyPort) {
            curl_setopt($this->session, CURLOPT_HTTPPROXYTUNNEL, true);
            curl_setopt($this->session, CURLOPT_PROXY, $this->proxyHost.':'.$this->proxyPort);
            if ($this->proxyType != null) {
                curl_setopt($this->session, CURLOPT_PROXYTYPE, $this->proxyType);
            }
            if ($this->proxyUsername && $this->proxyPassword) {
                curl_setopt($this->session, CURLOPT_PROXYUSERPWD, $this->proxyUsername.':'.$this->proxyPassword);
                if ($this->proxyAuthType != null) {
                    curl_setopt($this->session, CURLOPT_PROXYAUTH, $this->proxyAuthType);
                }
            }
        }

        if (!empty($this->referer)) {
            curl_setopt($this->session, CURLOPT_REFERER, $this->referer);
        }

        curl_setopt($this->session, CURLOPT_HEADER, true);
        curl_setopt($this->session, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($this->session, CURLOPT_USERAGENT, $this->useragent);
        curl_setopt($this->session, CURLOPT_URL, $this->url);
        curl_setopt($this->session, CURLOPT_VERBOSE, false);
        curl_setopt($this->session, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->session, CURLOPT_ENCODING, 'gzip');
        curl_setopt($this->session, CURLINFO_HEADER_OUT, true);

        if (is_array($this->options) && count($this->options) > 0) {
            foreach ($this->options as $option => $value) {
                curl_setopt($this->session, $option, $value);
            }
        }

        $redirectCount = 0;
        if (ini_get('open_basedir') == '' && !ini_get('safe_mode')) {
            curl_setopt($this->session, CURLOPT_FOLLOWLOCATION, $this->redirect);
            curl_setopt($this->session, CURLOPT_MAXREDIRS, $this->maxRedirect);
        } else {
            curl_setopt($this->session, CURLOPT_FOLLOWLOCATION, false);
            $redirectCount = $this->follow();
        }

        $response = curl_exec($this->session);
        $this->infos = curl_getinfo($this->session);
        if ($redirectCount > 0) {
            $this->infos['redirect_count'] = $redirectCount;
        }

        $this->cwsDebug->labelValue('URL', $this->url, CwsDebug::VERBOSE_SIMPLE);
        $this->cwsDebug->labelValue('Method', $this->method, CwsDebug::VERBOSE_SIMPLE);
        $this->cwsDebug->labelValue('Params', $data, CwsDebug::VERBOSE_SIMPLE);
        $this->cwsDebug->labelValue('Timeout', $this->timeout, CwsDebug::VERBOSE_SIMPLE);
        $this->cwsDebug->labelValue('Referer', $this->referer, CwsDebug::VERBOSE_SIMPLE);
        $this->cwsDebug->labelValue('User agent', $this->useragent, CwsDebug::VERBOSE_SIMPLE);
        $this->cwsDebug->labelValue('Authentication (username/password setted)', ($this->username && $this->password ? 'true' : 'false'), CwsDebug::VERBOSE_SIMPLE);
        $this->cwsDebug->labelValue('Redirect', ($this->redirect ? 'true' : 'false'), CwsDebug::VERBOSE_SIMPLE);
        $this->cwsDebug->labelValue('Max redirect', $this->maxRedirect, CwsDebug::VERBOSE_SIMPLE);
        $this->cwsDebug->labelValue('Proxy host', $this->proxyHost, CwsDebug::VERBOSE_SIMPLE);
        $this->cwsDebug->labelValue('Proxy port', $this->proxyPort, CwsDebug::VERBOSE_SIMPLE);
        $this->cwsDebug->labelValue('Proxy type', $this->proxyType, CwsDebug::VERBOSE_SIMPLE);
        $this->cwsDebug->labelValue('Proxy authentication (username/password setted)', ($this->proxyUsername && $this->proxyPassword ? 'true' : 'false'), CwsDebug::VERBOSE_SIMPLE);
        $this->cwsDebug->labelValue('Proxy authentication type', $this->proxyAuthType, CwsDebug::VERBOSE_SIMPLE);

        if ($response != null) {
            $response = $this->parseResponse($response, $this->infos);
            $this->headerFulltext = $response['headerFulltext'];
            $this->headers = $response['headers'];
            $this->status = $response['status'];
            $this->content = $response['content'];
        }

        $this->parseError(curl_errno($this->session), curl_error($this->session));

        $this->cwsDebug->labelValue('HTTP status code', $this->status, CwsDebug::VERBOSE_DEBUG);
        $this->cwsDebug->labelValue('Content size', strlen($this->content), CwsDebug::VERBOSE_REPORT);

        $this->cwsDebug->dump('Infos', $this->infos, CwsDebug::VERBOSE_REPORT);
        $this->cwsDebug->dump('Header fulltext', $this->headerFulltext, CwsDebug::VERBOSE_DEBUG);
        $this->cwsDebug->dump('Headers', $this->headers, CwsDebug::VERBOSE_DEBUG);

        curl_close($this->session);
    }

    /**
     * Redirection workaround
     * See http://www.php.net/manual/ro/function.curl-setopt.php#102121 for more infos.
     *
     * @return int : redirect count
     */
    private function follow()
    {
        $status = 0;
        $redirectCount = 0;
        $newurl = $this->url;
        $maxRedirect = $this->maxRedirect;

        $session = curl_copy_handle($this->session);
        curl_setopt($session, CURLOPT_HEADER, true);
        curl_setopt($session, CURLOPT_NOBODY, true);
        curl_setopt($session, CURLOPT_FORBID_REUSE, false);

        do {
            curl_setopt($session, CURLOPT_URL, $newurl);

            $response = curl_exec($session);
            $infos = curl_getinfo($session);

            $this->parseError(curl_errno($session), curl_error($session));

            if (empty($this->error)) {
                $response = $this->parseResponse($response, $infos);
                $status = $response['status'];
                if (($status == 301 || $status == 302) && isset($response['headers']['location'])) {
                    $redirectCount++;
                    $newurl = $response['headers']['location'];
                    if (!preg_match('#^https?:#i', $newurl)) {
                        $newurl = $this->url.$newurl;
                    }
                }
            }

            $maxRedirect--;
        } while ($status != 200 && $maxRedirect > 0);

        curl_close($session);

        if ($maxRedirect == 0 && ($status == 0 || $status == 301 || $status == 302)) {
            $this->error = 'Too many redirects...';
            $this->cwsDebug->error($this->error);

            return false;
        }

        curl_setopt($this->session, CURLOPT_URL, $newurl);

        return $redirectCount;
    }

    /**
     * Parse the response.
     *
     * @param string $response : the cURL response
     * @param array  $infos    : The cURL information regarding the transfer
     *
     * @return array : headerFulltext, headers, status and content
     */
    private function parseResponse($response, $infos)
    {
        $result = array(
            'headerFulltext' => '',
            'headers'        => array(),
            'status'         => 0,
            'content'        => '',
        );

        $length = isset($infos['header_size']) ? $infos['header_size'] : 0;

        if (!empty($response) && $length > 0) {
            $result['content'] = substr($response, $length, strlen($response));
            $tmp = explode("\r\n\r\n", substr($response, 0, $length));
            if (!empty($tmp)) {
                foreach ($tmp as $string) {
                    if (!empty($string)) {
                        $result['headerFulltext'] = str_replace("\r\n", "\n", $string);
                    }
                }
            }
            if (!empty($result['headerFulltext'])) {
                $headers = explode("\n", $result['headerFulltext']);
                if ($result['status'] == 0) {
                    if (preg_match_all('|HTTP/\d\.\d\s+(\d+)\s+.*|i', $headers[0], $matches) && isset($matches[1])
                        && isset($matches[1][0]) && is_numeric($matches[1][0])) {
                        $result['status'] = intval($matches[1][0]);
                        array_shift($headers);
                    } else {
                        $this->error = 'Unexpected HTTP response status...';
                        $this->cwsDebug->error($this->error);

                        return;
                    }
                }

                foreach ($headers as $header) {
                    $name = strtolower($this->tokenize($header, ':'));
                    $value = trim(rtrim($this->tokenize("\r\n")));

                    if (isset($result['headers'][$name])) {
                        if (gettype($result['headers'][$name]) == 'string') {
                            $result['headers'][$name] = array($result['headers'][$name]);
                        }
                        $result['headers'][$name][] = $value;
                    } else {
                        $result['headers'][$name] = $value;
                    }
                }
            }

            return $result;
        }
    }

    /**
     * Parse cURL and HTTP errors.
     *
     * @param int    $errno : the error number
     * @param string $error : a clear text error message
     */
    private function parseError($errno, $error)
    {
        $this->error = '';

        if ($errno > 0) {
            // More info: http://php.net/manual/en/function.curl-errno.php
            if ($errno == CURLE_COULDNT_RESOLVE_HOST) {
                $host = parse_url($this->url);
                $host = $host['host'];

                $this->error = 'cURL error '.$errno.' : Could not resolve hostname '.$host.'...';
                $this->cwsDebug->error($this->error);

                return;
            } elseif ($errno == CURLE_HTTP_NOT_FOUND) {
                $this->error = 'cURL error '.$errno.' : HTTP error '.$this->status.'...';
                if ($this->status == 406) {
                    $this->error .= ' URL does not allow access to its content...';
                }
                $this->cwsDebug->error($this->error);

                return;
            } elseif ($errno == CURLE_COULDNT_CONNECT) {
                $this->error = 'cURL error '.$errno.' : Connection failed to the URL...';
                $this->cwsDebug->error($this->error);

                return;
            } elseif ($errno == CURLE_OPERATION_TIMEOUTED) {
                $this->error = 'cURL error '.$errno.' : Access to the URL exceeded time...';
                $this->cwsDebug->error($this->error);

                return;
            } else {
                $this->error = 'cURL error '.$errno;
                $this->cwsDebug->error($this->error);

                return;
            }
        } elseif (!empty($error)) {
            $this->error = 'cURL error : '.$error;
            $this->cwsDebug->error($this->error);

            return;
        } elseif ($this->status == 400) {
            $this->error = 'HTTP error '.$this->status.' Bad request : The request contains bad syntax or can not be transmitted.';
            $this->cwsDebug->error($this->error);

            return;
        } elseif ($this->status == 401) {
            $this->error = 'HTTP error '.$this->status.' Not allowed : The request requires authentication. Authentication failed or have not yet been accomplished.';
            $this->cwsDebug->error($this->error);

            return;
        } elseif ($this->status == 403) {
            $this->error = 'HTTP error '.$this->status.' Access denied : The server refuses to grant the resource.';
            $this->cwsDebug->error($this->error);

            return;
        } elseif ($this->status == 404) {
            $this->error = 'HTTP error '.$this->status.' Document Not Found : The server can not find the requested page in the URL.';
            $this->cwsDebug->error($this->error);

            return;
        } elseif ($this->status == 500) {
            $this->error = 'HTTP error '.$this->status.' Internal Error : The server encountered an unexpected condition which prevented him from continuing your query.';
            $this->cwsDebug->error($this->error);

            return;
        }
    }

    /**
     * Parse header names/values.
     *
     * @param string $string
     * @param string $separator
     *
     * @return string
     */
    private function tokenize($string, $separator = '')
    {
        if (!strcmp($separator, '')) {
            $separator = $string;
            $string = $this->headerNextToken;
        }

        for ($character = 0; $character < strlen($separator); $character++) {
            if (gettype($position = strpos($string, $separator[$character])) == 'integer') {
                $found = (isset($found) ? min($found, $position) : $position);
            }
        }

        if (isset($found)) {
            $this->headerNextToken = substr($string, $found + 1);

            return substr($string, 0, $found);
        } else {
            $this->headerNextToken = '';

            return $string;
        }
    }

    /**
     * Add a query parameter to the cURL request.
     *
     * @param string $name
     * @param string $value
     */
    public function addParam($name, $value)
    {
        if (!empty($name) && !empty($value)) {
            $this->params[stripslashes(trim($name))] = stripslashes(trim($value));
        }
    }

    /**
     * Add an option for the cURL transfer.
     * List of options : http://php.net/manual/en/function.curl-setopt.php.
     *
     * @param int   $option : The CURLOPT_ option to set.
     * @param mixed $value  : The value to be set on option.
     */
    public function addOption($option, $value)
    {
        $this->options[$option] = $value;
    }

    /**
     * Set authentication to the cURL request.
     *
     * @param string $username
     * @param string $password
     */
    public function setAuth($username, $password)
    {
        if (!empty($username) && !empty($password)) {
            $this->username = stripslashes(trim($username));
            $this->password = stripslashes(trim($password));
        }
    }

    /**
     * Set a HTTP proxy to tunnel requests through.
     *
     * @param string $host
     * @param int    $port
     * @param int    $type
     */
    public function setProxy($host, $port, $type = CURLPROXY_HTTP)
    {
        if (!empty($host) && !empty($port)) {
            $this->proxyHost = stripslashes(trim($host));
            $this->proxyPort = intval($port);
            $this->proxyType = intval($type);
        }
    }

    /**
     * Set a HTTP proxy authentication.
     *
     * @param string $username
     * @param string $password
     * @param int    $authType
     */
    public function setProxyAuth($username, $password, $authType = CURLAUTH_BASIC)
    {
        if (!empty($username) && !empty($password)) {
            $this->proxyUsername = stripslashes(trim($username));
            $this->proxyPassword = stripslashes(trim($password));
            $this->proxyAuthType = intval($authType);
        }
    }

    /**
     * Getters and setters.
     */

    /**
     * URL to fetch.
     *
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the URL to fetch.
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * HTTP request method.
     *
     * @return string $method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set the DELETE HTTP request method.
     */
    public function setDeleteMethod()
    {
        $this->setMethod(self::METHOD_DELETE);
    }

    /**
     * Set the GET HTTP request method.
     */
    public function setGetMethod()
    {
        $this->setMethod(self::METHOD_GET);
    }

    /**
     * Set the HEAD HTTP request method.
     */
    public function setHeadMethod()
    {
        $this->setMethod(self::METHOD_HEAD);
    }

    /**
     * Set the POST HTTP request method.
     */
    public function setPostMethod()
    {
        $this->setMethod(self::METHOD_POST);
    }

    /**
     * Set the PUT HTTP request method.
     */
    public function setPutMethod()
    {
        $this->setMethod(self::METHOD_PUT);
    }

    /**
     * Set the HTTP request method.
     *
     * @param string $method
     */
    private function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * Query string parameters.
     *
     * @return array $params
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * The maximum number of seconds to allow cURL functions to execute.
     *
     * @return int $timeout
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Set the maximum number of seconds to allow cURL functions to execute.
     *
     * @param int $timeout
     */
    public function setTimeout($timeout)
    {
        $timeout = intval($timeout);
        if (!empty($timeout)) {
            $this->timeout = $timeout;
        }
    }

    /**
     * The contents of the "Referer: " header to be used in a HTTP request.
     *
     * @return string $referer
     */
    public function getReferer()
    {
        return $this->referer;
    }

    /**
     * Set the contents of the "Referer: " header to be used in a HTTP request.
     *
     * @param string $referer
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;
    }

    /**
     * The contents of the "User-Agent: " header to be used in a HTTP request.
     *
     * @return string $useragent
     */
    public function getUseragent()
    {
        return $this->useragent;
    }

    /**
     * Set the Chrome User-Agent to the contents of the "User-Agent: " header to be used in a HTTP request.
     */
    public function setChromeUseragent()
    {
        $this->setUseragent(self::UA_CHROME);
    }

    /**
     * Set the Firefox User-Agent to the contents of the "User-Agent: " header to be used in a HTTP request.
     */
    public function setFirefoxUseragent()
    {
        $this->setUseragent(self::UA_FIREFOX);
    }

    /**
     * Set the Googlebot User-Agent to the contents of the "User-Agent: " header to be used in a HTTP request.
     */
    public function setGooglebotUseragent()
    {
        $this->setUseragent(self::UA_GOOGLEBOT);
    }

    /**
     * Set the Internet Explorer User-Agent to the contents of the "User-Agent: " header to be used in a HTTP request.
     */
    public function setIeUseragent()
    {
        $this->setUseragent(self::UA_IE);
    }

    /**
     * Set the Opera User-Agent to the contents of the "User-Agent: " header to be used in a HTTP request.
     */
    public function setOperaUseragent()
    {
        $this->setUseragent(self::UA_OPERA);
    }

    /**
     * Set the contents of the "User-Agent: " header to be used in a HTTP request.
     *
     * @param string $useragent
     */
    public function setUseragent($useragent)
    {
        $this->useragent = $useragent;
    }

    /**
     * The username for the CURLOPT_USERPWD option.
     *
     * @return string $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * The password associated to the username for the CURLOPT_USERPWD option.
     *
     * @return string $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Redirects allowed.
     *
     * @return bool
     */
    public function isRedirect()
    {
        return $this->redirect;
    }

    /**
     * Set allow redirects.
     *
     * @param bool $redirect
     */
    public function setRedirect($redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     * Maximum redirects allowed.
     *
     * @return int $maxRedirect
     */
    public function getMaxRedirect()
    {
        return $this->maxRedirect;
    }

    /**
     * Set the maximum redirects allowed.
     *
     * @param int $maxRedirect
     */
    public function setMaxRedirect($maxRedirect)
    {
        $maxRedirect = intval($maxRedirect);
        if (!empty($maxRedirect)) {
            $this->maxRedirect = $maxRedirect;
        }
    }

    /**
     * The host IP of the proxy to connect to.
     *
     * @return string $proxyHost
     */
    public function getProxyHost()
    {
        return $this->proxyHost;
    }

    /**
     * The port number of the proxy to connect to.
     *
     * @return int $proxyPort
     */
    public function getProxyPort()
    {
        return $this->proxyPort;
    }

    /**
     * The proxy type CURLPROXY_HTTP, CURLPROXY_SOCKS4 or CURLPROXY_SOCKS5.
     *
     * @return string $proxyType
     */
    public function getProxyType()
    {
        return $this->proxyType;
    }

    /**
     * The HTTP authentication method(s) to use for the proxy connection.
     * Can be CURLAUTH_BASIC or CURLAUTH_NTLM.
     *
     * @return string $proxyAuthType
     */
    public function getProxyAuthType()
    {
        return $this->proxyAuthType;
    }

    /**
     * The username for the CURLOPT_PROXYUSERPWD option.
     *
     * @return string $proxyUsername
     */
    public function getProxyUsername()
    {
        return $this->proxyUsername;
    }

    /**
     * The password associated to the proxyUsername for the CURLOPT_PROXYUSERPWD option.
     *
     * @return string $proxyPassword
     */
    public function getProxyPassword()
    {
        return $this->proxyPassword;
    }

    /**
     * The cURL session.
     *
     * @return resource $session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * The HTTP status code returned.
     *
     * @return int $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * The content transferred.
     *
     * @return string $content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * The cURL information regarding the transfer.
     *
     * @return object $infos
     */
    public function getInfos()
    {
        return $this->infos;
    }

    /**
     * The header fulltext response.
     *
     * @return string $headerFulltext
     */
    public function getHeaderFulltext()
    {
        return $this->headerFulltext;
    }

    /**
     * The headers response.
     *
     * @return array $headers
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * The last error.
     *
     * @return string $error
     */
    public function getError()
    {
        return $this->error;
    }
}
