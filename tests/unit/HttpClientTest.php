<?php
declare(strict_types=1);

use I4code\PleskApi\HttpClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class HttpClientTest extends TestCase
{
    private $baseUrl;
    private $config;

    public function setUp(): void
    {
        $scheme = 'http';
        $port = '80';
        $path = '';
        $host = 'httpbin.org';
        $this->config = [
            'scheme' => $scheme,
            'port' => $port,
            'host' => $host,
            'path' => $path,
        ];
        $this->baseUrl = "{$scheme}://{$host}:{$port}{$path}";
    }

    public function testConstruct()
    {
        $httpClient = new HttpClient($this->config);
        $this->assertInstanceOf(HttpClient::class, $httpClient);
        return $httpClient;
    }

    /**
     * @depends testConstruct
     */
    public function testGetBaseUrl($client)
    {
        $uri = $client->getBaseUrl();
        $expected = $this->baseUrl . $path;
        $this->assertEquals($expected, $uri);
    }

    /**
     * @depends testConstruct
     */
    public function testBuildUri($client)
    {
        $path = '/test';
        $uri = $client->buildUri($path);
        $expected = $this->baseUrl . $path;
        $this->assertEquals($expected, $uri);
    }

    /**
     * @depends testConstruct
     */
    public function testGet($client)
    {
        $path = '/get';
        $response = $client->get($path);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @depends testConstruct
     */
    public function testPost($client)
    {
        $path = '/post';
        $payload = (object) [];
        $response = $client->post($path, $payload);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

}
