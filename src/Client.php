<?php
declare(strict_types=1);

namespace I4code\PleskApi;


class Client
{
    private $host;
    private $httpClient;

    private $auth;


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
        return $this->authenticate($this->httpClient);
    }


    public function setAuth(object $auth)
    {
        $this->auth = $auth;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getAuth()
    {
        return $this->auth;
    }


    public function authenticate(HttpClient $httpClient)
    {
        $auth = $this->getAuth();
        if (is_object($auth)) {
            if ('login' == $auth->type) {
                $httpClient->addHeader('Authorization', sprintf('Basic %s', base64_encode($this->auth->user . ':' . $this->auth->password)));
            }
        }
        return $httpClient;
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