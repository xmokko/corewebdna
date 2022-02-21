<?php

use HTTPClient\HTTPClient;
use HTTPClient\HTTPException;

class App
{
    private HTTPClient $client;

    public function __construct()
    {
        $url = 'https://corednacom.corewebdna.com/assessment-endpoint.php';
        $this->client = new HTTPClient($url);
    }

    public function run()
    {
        try {
            $bearerToken = $this->client
                ->setMethod('OPTIONS')
                ->setHeaders("Accept-language: en")
                ->setHeaders("Content-type: application/json")
                ->send();

            print "Bearer Token: " . $bearerToken . PHP_EOL;

            $this->client
                ->setMethod('POST')
                ->setBearerToken($bearerToken)
                ->setContent($this->getUserData())
                ->setHeaders("Accept-language: en")
                ->send();

        } catch (HTTPException|Exception $e) {
            print ("{$e->getCode()} {$e->getMessage()}");
        }
    }

    protected function getUserData()
    {
        return json_encode([
            'name' => 'John Doe',
            'email' => 'spamwelcomedhere@gmail.com',
            'url' => 'https://github.com/john-doe/httpClient-client'
        ]);
    }
}
