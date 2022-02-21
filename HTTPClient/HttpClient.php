<?php

namespace HttpClient;

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
//    No external libraries allowed! All code must be hand-written.
//    Explicit use of CURL (e.g. curl_exec()) is not allowed!

class HttpClient
{
    private string $url;
    private string $method = 'GET';

    public function __construct($url)
    {
        $this->url = $url;
    }
}
