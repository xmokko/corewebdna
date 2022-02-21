<?php

namespace HTTPClient;

use Exception;

// TODO:
//    Send HTTP requests to the given URL using different methods, such as GET, POST, etc.
//    Send JSON payloads
//    Send custom HTTP headers
//    Retrieve HTTP response payloads
//    Retrieve/parse HTTP response headers
//    All JSON payloads must be passed in as associative arrays
//    All JSON payloads must be returned as associative arrays
//    Any JSON conversion errors must throw an exception
//    Erroneous HTTP response codes (e.g. 4xx, 5xx) must throw an exception

/**
 * Simple HTTP client
 */
class HTTPClient
{
    /** Bearer Authentication token */
    private string $bearerToken = '';
    /** Http request header content */
    private string $content = '';
    /** Http request headers */
    private array $headers;
    private array $httpResponseHeader;
    private string $method = 'GET';
    private string $url;

    public function __construct($url)
    {
        $this->setUrl($url);
    }

    /**
     * Send Request
     * @throws HTTPException
     */
    public function send(): string
    {
        $content = @file_get_contents($this->getUrl(), false, $this->httpRequestOptions());

        if ($content === false) {
            throw new HTTPException();
        }

        $this->setHttpResponseHeader($http_response_header);

        return $content;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl($url): HTTPClient
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Collect request headers
     * @return resource
     */
    protected function httpRequestOptions()
    {
        $headers = implode("\r\n", $this->getHeaders()) . "\r\n";
        if ($this->getBearerToken() !== '') {
            $headers .= 'Authorization: Bearer ' . $this->getBearerToken() . "\r\n";
        }

        $httpRequestOptions = array(
            'http' => array(
                'method' => $this->method,
                'header' => $headers,
            )
        );

        if (in_array($this->getMethod(), ['PUT', 'POST']) && $this->getContent() !== '') {
            $httpRequestOptions['http']['header'] .= "Content-type: application/json\r\n";
            $httpRequestOptions['http']['content'] = $this->getContent();
        }

        return stream_context_create($httpRequestOptions);
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders($headers): HTTPClient
    {
        $this->headers[] = $headers;
        return $this;
    }

    public function getBearerToken(): string
    {
        return $this->bearerToken;
    }

    public function setBearerToken($bearerToken): HTTPClient
    {
        $this->bearerToken = $bearerToken;
        return $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @throws Exception
     */
    public function setMethod($method): HTTPClient
    {
        if (!in_array($method, ['GET', 'POST', 'PUT', 'OPTIONS'])) {
            throw new Exception("Can't set method!");
        }

        $this->method = $method;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent($content): HTTPClient
    {
        $this->content = $content;
        return $this;
    }

    public function getHttpResponseHeader(): array
    {
        return $this->httpResponseHeader;
    }

    protected function setHttpResponseHeader($httpResponseHeader)
    {
        $this->httpResponseHeader = $httpResponseHeader;
    }
}
