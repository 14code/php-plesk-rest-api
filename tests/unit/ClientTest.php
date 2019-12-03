<?php
declare(strict_types=1);

use I4code\PleskApi\Client;
use PHPUnit\Framework\TestCase;


class ClientTest extends TestCase
{
    private $host;
    private $auth;

    public function setUp(): void
    {
        $this->host = \I4code\PleskApi\selectHost();
        $this->auth = \I4code\PleskApi\getAuthFromEnv();

        if (empty($this->auth)) {
            $this->auth = \I4code\PleskApi\useToken();
        }

        if (empty($this->auth)) {
            $this->auth = \I4code\PleskApi\useCredentials();
        }
    }

    public function testConstruct()
    {
        $client = new Client($this->host);
        $this->assertInstanceOf(Client::class, $client);
    }

    public function testSetAuth()
    {
        fwrite(STDIN, php_sapi_name());
        $client = new Client($this->host);
        $client->setAuth($this->auth);
        $this->assertTrue(true);
    }

    public function testGetServerInfo()
    {
        $client = new Client($this->host);
        $client->setAuth($this->auth);
        $serverInfo = $client->getServerInfo();
        $this->assertIsObject($serverInfo);
    }

    public function testGetDomains()
    {
        $client = new Client($this->host);
        $client->setAuth($this->auth);
        $domains = $client->getDomains();
        $this->assertIsArray($domains);
    }

}
