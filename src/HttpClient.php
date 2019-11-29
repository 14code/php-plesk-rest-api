<?php
declare(strict_types=1);

namespace I4code\PleskApi;


use Psr\Http\Message\RequestInterface;

class HttpClient
{
    protected $config = [
        'scheme' => 'http',
        'host' => 'localhost',
        'port' => '80',
        'path' => ''
    ];
    private $auth;
    private $psr17Factory;
    private $psr18Client;


    public function __construct(array $config = null)
    {
        if (is_array($config)) {
            $this->config = $config;
        }
        $this->psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();
        $this->psr18Client = new \Buzz\Client\Curl($this->psr17Factory);
    }


    public function getBaseUrl()
    {
        if (empty($baseUrl)) {
            $this->baseUrl = $this->config['scheme'] . '://' . $this->config['host']
                . ':' . $this->config['port'] . $this->config['path'];
        }
        return $this->baseUrl;
    }


    public function buildUri($path)
    {
        return $this->getBaseUrl() . $path;
    }


    public function createRequest($method, $uri)
    {
        $request = $this->psr17Factory->createRequest($method, $uri);
        if (is_array($this->auth)) {
            $request = $this->authenticateRequest($request);
        }
        return $request;
    }


    public function authenticateRequest(RequestInterface $request)
    {
        if (is_array($this->auth)) {
            $request = $request->withAddedHeader('Authorization', sprintf('Basic %s', base64_encode($this->auth['user'] . ':' . $this->auth['password'])));
        }
        return $request;
    }


    public function authenticate($user, $password)
    {
        $this->auth = [
            'user' => $user,
            'password' => $password
        ];
        return $this;
    }


    public function get($path)
    {
        $uri = $this->buildUri($path);
        $request = $this->createRequest('GET', $uri);
        return $this->psr18Client->sendRequest($request);
    }


    public function post($path, $payload)
    {
        $uri = $this->buildUri($path);
        $request = $this->psr17Factory->createRequest('POST', $uri);
        $request->getBody()->write(json_encode($this->payload));
        return $this->psr18Client->sendRequest($request);
    }

}