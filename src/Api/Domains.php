<?php
declare(strict_types=1);

namespace I4code\PleskApi\Api;

class Domains extends Api
{
    protected $path = '/domains';

    public function all()
    {
        return $this->get($this->getPath());
    }

}