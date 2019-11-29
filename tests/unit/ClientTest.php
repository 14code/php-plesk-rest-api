<?php
declare(strict_types=1);

use I4code\PleskApi\Client;
use PHPUnit\Framework\TestCase;


class ClientTest extends TestCase
{
    private $host;
    private $token;
    private $user;
    private $pass;

    public function setUp(): void
    {
        $this->host = getenv('TESTAPIHOST');
        if (empty($this->host)) {
            fwrite(STDERR, "\n");
            fwrite(STDERR, 'Please insert API host: ');
            $this->host = trim(fgets(STDIN));
            fwrite(STDERR, "\n");
            putenv('TESTAPIHOST=' . $this->host);
        }

        $this->token = getenv('TESTAPITOKEN');
        if (empty($this->token)) {
            fwrite(STDERR, "\n");
            fwrite(STDERR, 'If available insert API token here or press enter for generating a new: ');
            fwrite(STDERR, "\n");
            $this->token = trim(fgets(STDIN));
            fwrite(STDERR, "\n");
            putenv('TESTAPITOKEN=' . $this->token);
        }

        $this->user = getenv('TESTAPIUSER');
        $this->pass = getenv('TESTAPIPASS');
        if (empty($this->token)) {
            if (empty($this->user)) {
                fwrite(STDERR, "\n");
                fwrite(STDERR, 'User not set. Please insert name: ');
                $this->user = trim(fgets(STDIN));
                putenv('TESTAPIUSER=' . $this->user);
            }
            if (empty($this->pass)) {
                fwrite(STDERR, "Password required for user '{$this->user}': ");
                $this->pass = trim(fgets(STDIN));
                putenv('TESTAPIPASS=' . $this->pass);
            }
            $this->token = uniqid();
            putenv('TESTAPITOKEN=' . $this->token);
        }

    }

    public function testConstruct()
    {
        $client = new Client($this->host);
        $this->assertInstanceOf(Client::class, $client);
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
