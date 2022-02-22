<?php

namespace App;

use HTTPClient\HTTPClient;
use HTTPClient\HTTPException;
use JsonException;
use Exception;

/**
 * HTTP client application
 */
class App
{
    /** Simple HTTP client */
    private HTTPClient $client;

    /**
     * Construct the application.
     */
    public function __construct()
    {
        $url = 'https://corednacom.corewebdna.com/assessment-endpoint.php';
        $this->client = new HTTPClient($url);
    }

    /**
     * Run application - send requests
     * @return void
     */
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

            print $this->client->getHttpResponseHeaders()[0];

        } catch (JsonException $e) {
            print ("JSON: {$e->getCode()} {$e->getMessage()}");
        } catch (HTTPException|Exception $e) {
            print ("{$e->getCode()} {$e->getMessage()}");
        }
    }

    /**
     * User data for send
     * @return string[]
     */
    protected function getUserData(): array
    {
        return [
            'name' => 'Stanislav Yeremenko',
            'email' => 'stanislav.yeremenko@chisw.com',
            'url' => 'https://github.com/xmokko/corewebdna'
        ];
    }
}
