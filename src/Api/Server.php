<?php
declare(strict_types=1);

namespace I4code\PleskApi\Api;

use I4code\PleskApi\Api\Server\Ips;
use I4code\PleskApi\Client;

class Server extends Api
{
    protected $path = '/server';

    public function show()
    {
        return $this->get($this->getPath());
    }

    public function ips()
    {
        return new Ips($this->getClient());
    }

}