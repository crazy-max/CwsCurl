<?php

/**
 * CwsCurl
 *
 * CwsCurl is a flexible wrapper PHP class for the cURL extension.
 * 
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation, either version 3 of the License, or (at your option)
 * any later version.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 * 
 * Please see the GNU General Public License at http://www.gnu.org/licenses/.
 * 
 * Related post : http://goo.gl/fI1Zy
 * 
 * @package CwsCurl
 * @author Cr@zy
 * @copyright 2013, Cr@zy
 * @license GPL licensed
 * @version 1.1
 * @link https://github.com/crazy-max/CwsCurl
 *
 */

define('CWSCURL_VERBOSE_QUIET',     0); // means no output at all.
define('CWSCURL_VERBOSE_SIMPLE',    1); // means only output simple report.
define('CWSCURL_VERBOSE_REPORT',    2); // means output a detail report.
define('CWSCURL_VERBOSE_DEBUG',     3); // means output detail report as well as debug info.

define('CWSCURL_METHOD_DELETE',     'DELETE');
define('CWSCURL_METHOD_GET',        'GET');
define('CWSCURL_METHOD_HEAD',       'HEAD');
define('CWSCURL_METHOD_POST',       'POST');
define('CWSCURL_METHOD_PUT',        'PUT');

define('CWSCURL_UA_CHROME',         'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.872.0 Safari/535.2');
define('CWSCURL_UA_FIREFOX',        'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.9');
define('CWSCURL_UA_GOOGLEBOT',      'Googlebot/2.1 ( http://www.googlebot.com/bot.html)');
define('CWSCURL_UA_IE',             'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0)');
define('CWSCURL_UA_OPERA',          'Opera/9.80 (Windows NT 6.1; U; en-US) Presto/2.9.181 Version/12.00');

class CwsCurl
{
    /**
     * CwsCurl version.
     * @var string
     */
    private $version = "1.1";
    
    /**
     * The URL to fetch.
     * @var string
     */
    private $url;
    
    /**
     * HTTP request method.
     * default CWSCURL_METHOD_GET
     * @var string
     */
    private $method = CWSCURL_METHOD_GET;
    
    /**
     * Query string parameters.
     * @var array
     */
    private $params;
    
    /**
     * List of options for the cURL transfer.
     * @var array
     */
    private $options;
    
    /**
     * The maximum number of seconds to allow cURL functions to execute.
     * default 10
     * @var int
     */
    private $timeout = 10;
    
    /**
     * The contents of the "Referer: " header to be used in a HTTP request.
     * @var string
     */
    private $referer;
    
    /**
     * The contents of the "User-Agent: " header to be used in a HTTP request.
     * default CWSCURL_UA_FIREFOX
     * @var string
     */
    private $useragent = CWSCURL_UA_FIREFOX;
    
    /**
     * The username for the CURLOPT_USERPWD option.
     * @var string
     */
    private $username;
    
    /**
     * The password associated to the username for the CURLOPT_USERPWD option.
     * @var string
     */
    private $password;
    
    /**
     * Allow redirects.
     * default true
     * @var boolean
     */
    private $redirect = true;
    
    /**
     * Maximum redirects allowed.
     * default 3
     * @var int
     */
    private $max_redirect = 3;
    
    /**
     * The hosqt IP of the proxy to connect to.
     * @var string
     */
    private $proxy_host;
    
    /**
     * The port number of the proxy to connect to.
     * @var int
     */
    private $proxy_port;
    
    /**
     * The proxy type CURLPROXY_HTTP, CURLPROXY_SOCKS4 or CURLPROXY_SOCKS5.
     * @var int
     */
    private $proxy_type;
    
    /**
     * The HTTP authentication method(s) to use for the proxy connection.
     * Can be CURLAUTH_BASIC or CURLAUTH_NTLM.
     * @var int
     */
    private $proxy_auth_type;
    
    /**
     * The username for the CURLOPT_PROXYUSERPWD option.
     * @var string
     */
    private $proxy_username;
    
    /**
     * The password associated to the proxy_username for the CURLOPT_PROXYUSERPWD option.
     * @var string
     */
    private $proxy_password;
    
    /**
     * The cURL session.
     * @var object
     */
    private $session;
    
    /**
     * The HTTP status code returned.
     * @var int
     */
    private $status;
    
    /**
     * The content transferred.
     * @var string
     */
    private $content;
    
    /**
     * The cURL information regarding the transfer.
     * @var object
     */
    private $infos;
    
    /**
     * The header fulltext response.
     * @var string
     */
    private $header_fulltext;
    
    /**
     * The headers response.
     * @var array
     */
    private $headers;
    
    /**
     * Control the debug output.
     * default CWSCURL_VERBOSE_SIMPLE
     * @var int
     */
    private $debug_verbose = CWSCURL_VERBOSE_SIMPLE;
    
    /**
     * The last error message.
     * @var string
     */
    private $error_msg;
    
    /**
     * A temporary token for headers parsing.
     * @var array
     */
    private $_next_token;
    
    /**
     * Defines new line ending.
     * @var string
     */
    private $_newline = "<br />\n";
    
    /**
     * Output additional msg for debug.
     * @param string $msg : if not given, output the last error msg.
     * @param int $verbose_level : the output level of this message.
     * @param boolean $newline : insert new line or not.
     * @param boolean $code : is code or not.
     */
    private function output($msg=false, $verbose_level=CWSCURL_VERBOSE_SIMPLE, $newline=true, $code=false)
    {
        if ($this->debug_verbose >= $verbose_level) {
            if (empty($msg) && !$code) {
                echo $this->_newline . '<strong>ERROR :</strong> ' . $this->error_msg;
            } else {
                if ($code) {
                    echo '<textarea style="width:100%;height:300px;">';
                    print_r($msg);
                    echo '</textarea>';
                } else {
                    echo $msg;
                }
            }
            if ($newline) {
                echo $this->_newline;
            }
        }
    }
    
    /**
     * Start process
     */
    public function process()
    {
        $this->output('<h2>process</h2>', CWSCURL_VERBOSE_SIMPLE, false);
        
        if (!in_array('curl', get_loaded_extensions())) {
            $this->error_msg = "The cURL extension is not loaded...";
            $this->output();
            exit();
        }
        
        $this->session = curl_init();
        curl_setopt($this->session, CURLOPT_NOBODY, false);
        
        $data = null;
        if (is_array($this->params) && count($this->params) > 0) {
            $data = http_build_query($this->params);
        }
        
        switch ($this->method) {
            case CWSCURL_METHOD_DELETE:
                curl_setopt($this->session, CURLOPT_CUSTOMREQUEST, CWSCURL_METHOD_DELETE);
                break;
            case CWSCURL_METHOD_GET:
                if ($data != null) {
                    $this->url = $this->url . '?' . $data;
                }
                curl_setopt($this->session, CURLOPT_HTTPGET, true);
                break;
            case CWSCURL_METHOD_HEAD:
                curl_setopt($this->session, CURLOPT_NOBODY, true);
               break;
            case CWSCURL_METHOD_POST:
                if ($data !== null) {
                    curl_setopt($this->session, CURLOPT_POST, true);
                    curl_setopt($this->session, CURLOPT_POSTFIELDS, $data);
                } else {
                    curl_setopt($this->session, CURLOPT_CUSTOMREQUEST, CWSCURL_METHOD_POST);
                }
                break;
            case CWSCURL_METHOD_PUT:
                if ($data !== null) {
                    $handle = fopen('php://temp', 'rw+');
                    fwrite($handle, $data);
                    rewind($handle);
                    
                    curl_setopt($this->session, CURLOPT_INFILE, $handle);
                    curl_setopt($this->session, CURLOPT_INFILESIZE, strlen($data));
                    curl_setopt($this->session, CURLOPT_PUT, true);
                } else {
                    curl_setopt($this->session, CURLOPT_CUSTOMREQUEST, CWSCURL_METHOD_PUT);
                }
                break;
        }
        
        if ($this->username && $this->password) {
            curl_setopt($this->session, CURLOPT_USERPWD, $this->username . ':' . $this->password);
        }
        
        if ($this->proxy_host && $this->proxy_port) {
            curl_setopt($this->session, CURLOPT_HTTPPROXYTUNNEL, true);
            curl_setopt($this->session, CURLOPT_PROXY, $this->proxy_host . ':' . $this->proxy_port);
            if ($this->proxy_type != null) {
                curl_setopt($this->session, CURLOPT_PROXYTYPE, $this->proxy_type);
            }
            if ($this->proxy_username && $this->proxy_password) {
                curl_setopt($this->session, CURLOPT_PROXYUSERPWD, $this->proxy_username . ':' . $this->proxy_password);
                if ($this->proxy_auth_type != null) {
                    curl_setopt($this->session, CURLOPT_PROXYAUTH, $this->proxy_auth_type);
                }
            }
        }
        
        curl_setopt($this->session, CURLOPT_HEADER, true);
        curl_setopt($this->session, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($this->session, CURLOPT_USERAGENT, $this->useragent);
        curl_setopt($this->session, CURLOPT_URL, $this->url);
        curl_setopt($this->session, CURLOPT_REFERER, $this->referer);
        curl_setopt($this->session, CURLOPT_VERBOSE, false);
        curl_setopt($this->session, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->session, CURLOPT_FOLLOWLOCATION, $this->redirect);
        curl_setopt($this->session, CURLOPT_MAXREDIRS, $this->max_redirect);
        curl_setopt($this->session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->session, CURLOPT_ENCODING, 'gzip');
        curl_setopt($this->session, CURLINFO_HEADER_OUT, true);
        
        if (is_array($this->options) && count($this->options) > 0) {
            foreach ($this->options as $option => $value) {
                curl_setopt($this->session, $option, $value);
            }
        }
        
        $this->output('<strong>URL : </strong>' . $this->url, CWSCURL_VERBOSE_SIMPLE);
        $this->output('<strong>Method : </strong>' . $this->method, CWSCURL_VERBOSE_SIMPLE);
        $this->output('<strong>Params : </strong>' . $data, CWSCURL_VERBOSE_SIMPLE);
        $this->output('<strong>Timeout : </strong>' . $this->timeout, CWSCURL_VERBOSE_SIMPLE);
        $this->output('<strong>Referer : </strong>' . $this->referer, CWSCURL_VERBOSE_SIMPLE);
        $this->output('<strong>User agent : </strong>' . $this->useragent, CWSCURL_VERBOSE_SIMPLE);
        $this->output('<strong>Authentication (username/password setted) : </strong>' . ($this->username && $this->password ? "true" : "false"), CWSCURL_VERBOSE_SIMPLE);
        $this->output('<strong>Redirect : </strong>' . ($this->redirect ? "true" : "false"), CWSCURL_VERBOSE_SIMPLE);
        $this->output('<strong>Max redirect : </strong>' . $this->max_redirect, CWSCURL_VERBOSE_SIMPLE);
        $this->output('<strong>Proxy host : </strong>' . $this->proxy_host, CWSCURL_VERBOSE_SIMPLE);
        $this->output('<strong>Proxy port : </strong>' . $this->proxy_port, CWSCURL_VERBOSE_SIMPLE);
        $this->output('<strong>Proxy type : </strong>' . $this->proxy_type, CWSCURL_VERBOSE_SIMPLE);
        $this->output('<strong>Proxy authentication (username/password setted) : </strong>' . ($this->proxy_username && $this->proxy_password ? "true" : "false"), CWSCURL_VERBOSE_SIMPLE);
        $this->output('<strong>Proxy authentication type : </strong>' . $this->proxy_auth_type, CWSCURL_VERBOSE_SIMPLE);
        
        $response = curl_exec($this->session);
        $this->infos = curl_getinfo($this->session);
        
        $this->parseHeaders($response);
        $this->parseError(curl_errno($this->session), curl_error($this->session));
        
        $this->output('<h3>infos</h3>', CWSCURL_VERBOSE_REPORT, false);
        $this->output($this->infos, CWSCURL_VERBOSE_REPORT, false, true);
        
        $this->output('<h3>HTTP status code</h3>', CWSCURL_VERBOSE_DEBUG, false);
        $this->output($this->status, CWSCURL_VERBOSE_DEBUG, false);
        
        $this->output('<h3>content</h3>', CWSCURL_VERBOSE_REPORT, false);
        $this->output('Size : ' . strlen($this->content), CWSCURL_VERBOSE_REPORT, false);
        
        $this->output('<h3>header fulltext</h3>', CWSCURL_VERBOSE_DEBUG, false);
        $this->output($this->header_fulltext, CWSCURL_VERBOSE_DEBUG, false, true);
        
        $this->output('<h3>headers</h3>', CWSCURL_VERBOSE_DEBUG, false);
        $this->output($this->headers, CWSCURL_VERBOSE_DEBUG, false, true);
        
        curl_close($this->session);
    }
    
    /**
     * Parse the headers.
     * @param string $response : the cURL response
     */
    private function parseHeaders($response)
    {
        $this->header_fulltext = '';
        $length = isset($this->infos['header_size']) ? $this->infos['header_size'] : 0;
        
        if (!empty($response) && $length > 0) {
            $this->content = substr($response, $length, strlen($response));
            $tmp = explode("\r\n\r\n", substr($response, 0, $length));
            if (!empty($tmp)) {
                foreach ($tmp as $string) {
                    if (!empty($string)) {
                        $this->header_fulltext = $string;
                    }
                }
            }
            if (!empty($this->header_fulltext)) {
                $headers = explode("\r\n", $this->header_fulltext);
                $this->headers = array();
                
                if ($this->status == 0) {
                    if (preg_match_all('|HTTP/\d\.\d\s+(\d+)\s+.*|i', $headers[0], $matches) && isset($matches[1]) && isset($matches[1][0]) && is_numeric($matches[1][0])) {
                        $this->status = intval($matches[1][0]);
                        array_shift($headers);
                    } else {
                        $this->error_msg = "Unexpected HTTP response status...";
                        $this->output();
                        return;
                    }
                }
                
                foreach ($headers as $header) {
                    $name = strtolower($this->tokenize($header, ':'));
                    $value = trim(chop($this->tokenize("\r\n")));
                    
                    if (isset($this->headers[$name])) {
                        if (gettype($this->headers[$name]) == "string") {
                            $this->headers[$name] = array($this->headers[$name]);
                        }
                        $this->headers[$name][] = $value;
                    } else {
                        $this->headers[$name] = $value;
                    }
                }
            }
            
            $this->header_fulltext = str_replace("\r\n", "\n", $this->header_fulltext);
        }
    }
    
    /**
     * Parse cURL and HTTP errors.
     * @param int $errno : the error number
     * @param string $error : a clear text error message
     */
    private function parseError($errno, $error)
    {
        $this->error_msg = '';
        if ($errno > 0) {
            // More info: http://php.net/manual/en/function.curl-errno.php
            if ($errno == CURLE_COULDNT_RESOLVE_HOST) {
                $host = parse_url($this->url);
                $host = $host['host'];
                
                $this->error_msg = "cURL error " . $errno . " : Could not resolve hostname " . $host . "...";
                $this->output();
                return;
            } elseif ($errno == CURLE_HTTP_NOT_FOUND) {
                $this->error_msg = "cURL error " . $errno . " : HTTP error " . $this->status . "...";
                if ($this->status == 406) {
                    $this->error_msg .= " URL does not allow access to its content...";
                }
                $this->output();
                return;
            } elseif ($errno == CURLE_COULDNT_CONNECT) {
                $this->error_msg = "cURL error " . $errno . " : Connection failed to the URL...";
                $this->output();
                return;
            } elseif ($errno == CURLE_OPERATION_TIMEOUTED) {
                $this->error_msg = "cURL error " . $errno . " : Access to the URL exceeded time...";
                $this->output();
                return;
            } else {
                $this->error_msg = "cURL error " . $errno;
                $this->output();
                return;
            }
        } elseif (!empty($error)) {
            $this->error_msg = "cURL error : " . $error;
            $this->output();
            return;
        } elseif ($this->status == 400) {
            $this->error_msg = "HTTP error " . $this->status . " Bad request : The request contains bad syntax or can not be transmitted.";
            $this->output();
            return;
        } elseif ($this->status == 401) {
            $this->error_msg = "HTTP error " . $this->status . " Not allowed : The request requires authentication. Authentication failed or have not yet been accomplished.";
            $this->output();
            return;
        } elseif ($this->status == 403) {
            $this->error_msg = "HTTP error " . $this->status . " Access denied : The server refuses to grant the resource.";
            $this->output();
            return;
        } elseif ($this->status == 404) {
            $this->error_msg = "HTTP error " . $this->status . " Document Not Found : The server can not find the requested page in the URL.";
            $this->output();
            return;
        } elseif ($this->status == 500) {
            $this->error_msg = "HTTP error " . $this->status . " Internal Error : The server encountered an unexpected condition which prevented him from continuing your query.";
            $this->output();
            return;
        }
        
        if (!empty($this->error_msg) && !empty($this->header_fulltext)) {
            $this->error_msg .= $this->_newline . $this->_newline . $this->header_fulltext;
        }
        
        if (!empty($this->error_msg)) {
            $this->output();
        }
    }
    
    /**
     * Parse header names/values
     * @param string $string
     * @param string $separator
     * @return string
     */
    private function tokenize($string, $separator='')
    {
        if (!strcmp($separator, '')) {
            $separator = $string;
            $string = $this->_next_token;
        }
        
        for ($character = 0; $character < strlen($separator); $character++) {
            if (gettype($position = strpos($string, $separator[$character])) == "integer") {
                $found = (isset($found) ? min($found, $position) : $position);
            }
        }
        
        if (isset($found)) {
            $this->_next_token = substr($string, $found + 1);
            return substr($string, 0, $found);
        } else {
            $this->_next_token = '';
            return $string;
        }
    }
    
    /**
     * Add custom parameters to the cURL request.
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
     * List of options : http://php.net/manual/en/function.curl-setopt.php
     * @param int $option : The CURLOPT_XXX option to set.
     * @param mixed $value : The value to be set on option.
     */
    public function addOption($option, $value)
    {
        $this->options[$option] = $value;
    }
    
    /**
     * Set authentication to the cURL request.
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
     * @param string $host
     * @param int $port
     * @param int $type
     */
    public function setProxy($host, $port, $type=CURLPROXY_HTTP)
    {
        if (!empty($host) && !empty($port)) {
            $this->proxy_host = stripslashes(trim($host));
            $this->proxy_port = intval($port);
            $this->proxy_type = intval($type);
        }
    }
    
    /**
     * Set a HTTP proxy authentication.
     * @param string $username
     * @param string $password
     * @param int $auth
     */
    public function setProxyAuth($username, $password, $auth_type=CURLAUTH_BASIC)
    {
        if (!empty($username) && !empty($password)) {
            $this->proxy_username = stripslashes(trim($username));
            $this->proxy_password = stripslashes(trim($password));
            $this->proxy_auth_type = intval($auth_type);
        }
    }
    
    /**
     * Auto-generated getters and setters
     */
    
    public function getVersion()
    {
        return $this->version;
    }
    
    public function getUrl()
    {
        return $this->url;
    }
    
    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    public function getMethod()
    {
        return $this->method;
    }
    
    public function setMethod($method)
    {
        $this->method = $method;
    }
    
    public function getParams()
    {
        return $this->params;
    }
    
    public function getTimeout()
    {
        return $this->timeout;
    }
    
    public function setTimeout($timeout)
    {
        $timeout = intval($timeout);
        if (!empty($timeout)) {
            $this->timeout = $timeout;
        }
    }
    
    public function getReferer()
    {
        return $this->referer;
    }
    
    public function setReferer($referer)
    {
        $this->referer = $referer;
    }
    
    public function getUseragent()
    {
        return $this->useragent;
    }
    
    public function setUseragent($useragent)
    {
        $this->useragent = $useragent;
    }
    
    public function getUsername()
    {
        return $this->username;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    public function getRedirect()
    {
        return $this->redirect;
    }
    
    public function getProxyHost()
    {
        return $this->proxy_host;
    }
    
    public function getProxyPort()
    {
        return $this->proxy_port;
    }
    
    public function getProxyType()
    {
        return $this->proxy_type;
    }
    
    public function getProxyAuthType()
    {
        return $this->proxy_auth_type;
    }
    
    public function getProxyUsername()
    {
        return $this->proxy_username;
    }
    
    public function getProxyPassword()
    {
        return $this->proxy_password;
    }
    
    public function setRedirect($redirect)
    {
        $this->redirect = $redirect;
    }
    
    public function getMaxRedirect()
    {
        return $this->max_redirect;
    }
    
    public function setMaxRedirect($max_redirect)
    {
        $max_redirect = intval($max_redirect);
        if (!empty($timeout)) {
            $this->max_redirect = $max_redirect;
        }
    }
    
    public function getSession()
    {
        return $this->session;
    }
    
    public function getStatus()
    {
        return $this->status;
    }
    
    public function getContent()
    {
        return $this->content;
    }
    
    public function getInfos()
    {
        return $this->infos;
    }
    
    public function getHeaderFulltext()
    {
        return $this->header_fulltext;
    }
    
    public function getHeaders()
    {
        return $this->headers;
    }
    
    public function getDebugVerbose()
    {
        return $this->debug_verbose;
    }
    
    public function setDebugVerbose($debug_verbose)
    {
        $this->debug_verbose = $debug_verbose;
    }
    
    public function getErrorMsg()
    {
        return $this->error_msg;
    }
}

?>