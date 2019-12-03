<?php


namespace I4code\PleskApi\Api;


use I4code\PleskApi\Client;

class Server
{
    protected $path = '/server';

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function show()
    {
        return $this->get($this->getPath());
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