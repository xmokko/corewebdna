<?php

namespace HTTPClient;

use Exception;
use JsonException;

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
    /** Http response headers */
    private array $httpResponseHeaders;
    /** Http method  */
    private string $method = 'GET';
    /** Http url */
    private string $url;

    /**
     * Construct the HTTPClient.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->setUrl($url);
    }

    /**
     * Send Http Request
     * @throws HTTPException
     */
    public function send(): string
    {
        $content = @file_get_contents($this->getUrl(), false, $this->httpRequestOptions());

        if ($content === false) {
            throw new HTTPException();
        }

        $this->setHttpResponseHeaders($http_response_header);

        return $content;
    }

    /**
     * Get Http url
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Set Http url
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url): HTTPClient
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

        $httpRequestOptions = [
            'http' => [
                'method' => $this->method,
                'header' => $headers,
            ]
        ];

        if (in_array($this->getMethod(), ['POST', 'PUT', 'PATCH']) && $this->getContent() !== '') {
            $httpRequestOptions['http']['header'] .= "Content-type: application/json\r\n";
            $httpRequestOptions['http']['content'] = $this->getContent();
        }

        return stream_context_create($httpRequestOptions);
    }

    /**
     * Get Request headers
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Set Request headers
     * @param string $headers
     * @return $this
     */
    public function setHeaders(string $headers): HTTPClient
    {
        $this->headers[] = $headers;
        return $this;
    }

    /**
     * Get Bearer Authentication token
     * @return string
     */
    public function getBearerToken(): string
    {
        return $this->bearerToken;
    }

    /**
     * Set Bearer Authentication token
     * @param string $bearerToken
     * @return $this
     */
    public function setBearerToken(string $bearerToken): HTTPClient
    {
        $this->bearerToken = $bearerToken;
        return $this;
    }

    /**
     * Get Http method
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Set Http method
     * @param string $method
     * @return HTTPClient
     * @throws Exception
     */
    public function setMethod(string $method): HTTPClient
    {
        if (!in_array($method, ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS', 'HEAD'])) {
            throw new Exception("Can't set method!");
        }

        $this->method = $method;
        return $this;
    }

    /**
     * Get Http request header content
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Set Http request header content
     * @param array $content
     * @return HTTPClient
     * @throws JsonException
     */
    public function setContent(array $content): HTTPClient
    {
        $this->content = json_encode($content, JSON_THROW_ON_ERROR);
        return $this;
    }

    /**
     * Get Http Response headers
     * @return array
     */
    public function getHttpResponseHeaders(): array
    {
        return $this->httpResponseHeaders;
    }

    /**
     * Set Http Response headers
     * @param array $httpResponseHeaders
     * @return void
     */
    protected function setHttpResponseHeaders(array $httpResponseHeaders)
    {
        $this->httpResponseHeaders = $httpResponseHeaders;
    }
}
