<?php

namespace App\OhDear\Services;

use App\OhDear\Site;

class OhDear extends \OhDear\PhpSdk\OhDear
{

    public function __construct()
    {
        $token = ''; // TODO: Get this token from the configuration set by the user.

        parent::__construct($token, null);
    }

    public function getSites()
    {
        return $this->collect($this->get('sites')['data'], Site::class);
    }

    public function collect($collection, $class)
    {
        return collect($collection)->map(function ($attributes) use ($class) {
            return new $class($attributes, $this);
        });
    }
}