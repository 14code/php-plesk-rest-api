<?php
declare(strict_types=1);

namespace I4code\PleskApi\Api;

use I4code\PleskApi\Client;

abstract class Api
{
    protected $path = '';
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get($path)
    {
        $httpClient = $this->getClient()->getHttpClient();
        $response = $httpClient->get($path);
        $json = (string) $response->getBody();
        return json_decode($json);
    }


    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

}