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
        $this->auth = \I4code\PleskApi\useToken();

        if (empty($this->auth)) {
            $this->auth = \I4code\PleskApi\useCredentials();
        }
    }

    public function testConstruct()
    {
        $client = new Client($this->host);
        $this->assertInstanceOf(Client::class, $client);
    }

    public function testAuthenticate()
    {
        fwrite(STDIN, php_sapi_name());
        $client = new Client($this->host);
        $client->authenticate($this->auth);
        $this->assertTrue($client->login());
    }

    public function testGetServerInfo()
    {
        $client = new Client($this->host);
        $client->authenticate($this->user, $this->pass);
        $serverInfo = $client->getServerInfo($this->user, $this->pass);
        $this->assertIsObject($serverInfo);
    }

    public function testGetDomains()
    {
        $client = new Client($this->host);
        $client->authenticate($this->user, $this->pass);
        $domains = $client->getDomains($this->user, $this->pass);
        $this->assertIsArray($domains);
    }

}
