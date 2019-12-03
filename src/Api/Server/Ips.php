<?php
declare(strict_types=1);

namespace I4code\PleskApi\Api\Server;

use I4code\PleskApi\Api\Api;

class Ips extends Api
{
    protected $path = '/server/ips';

    public function all()
    {
        return $this->get($this->getPath());
    }

}