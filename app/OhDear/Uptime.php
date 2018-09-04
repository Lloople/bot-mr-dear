<?php

namespace App\OhDear;

use Illuminate\Support\Carbon;
use OhDear\PhpSdk\Resources\ApiResource;

class Uptime extends ApiResource
{

    public function __construct(array $attributes, $ohDear = null)
    {
        parent::__construct($attributes, $ohDear);

        $this->datetime = Carbon::parse($this->datetime);
    }

}