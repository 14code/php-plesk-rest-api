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
        $serverApi = new \I4code\PleskApi\Api\Server($client);
        $serverInfo = $serverApi->show();
        $this->assertIsObject($serverInfo);
    }

    public function testGetServerIps()
    {
        $client = new Client($this->host);
        $client->setAuth($this->auth);
        $api = (new \I4code\PleskApi\Api\Server($client))->ips();
        $ips = $api->all();
        $this->assertIsArray($ips);
    }

    public function testGetDomains()
    {
        $client = new Client($this->host);
        $client->setAuth($this->auth);
        $domainsApi = new \I4code\PleskApi\Api\Domains($client);
        $domains = $domainsApi->all();
        fwrite(STDERR, print_r($domains, true));
        $this->assertIsArray($domains);
    }

}
