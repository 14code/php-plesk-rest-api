<?php
declare(strict_types=1);

namespace I4code\PleskApi;


class Client
{
    private $host;
    private $httpClient;
    private $token;


    public function __construct(string $host)
    {
        $this->host = $host;
    }


    /**
     * @param HttpClient $httpClient
     * @return Client
     */
    public function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getHttpClient()
    {
        if (null == $this->httpClient) {
            $config = [
                'scheme' => 'https',
                'host' => $this->host,
                'port' => '8443',
                'path' => '/api/v2'
            ];
            $this->httpClient = new HttpClient($config);
        }
        return $this->httpClient;
    }


    public function authenticate($user, $password)
    {
        $httpClient = $this->getHttpClient();
        $httpClient->authenticate($user, $password);
        return $this;
    }


    public function getServerInfo()
    {
        $httpClient = $this->getHttpClient();
        $response = $httpClient->get('/server');
        $json = (string) $response->getBody();
        fwrite(STDERR, $json);
        return json_decode($json);
    }


    public function getDomains()
    {
        $httpClient = $this->getHttpClient();
        $response = $httpClient->get('/domains');
        $json = (string) $response->getBody();
        fwrite(STDERR, $json);
        return json_decode($json);
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

}