<?php

namespace App\OhDear;

use Carbon\Carbon;
use OhDear\PhpSdk\Resources\ApiResource;

class Downtime extends ApiResource
{

    public function __construct(array $attributes, $ohDear = null)
    {
        parent::__construct($attributes, $ohDear);

        $this->startedAt = Carbon::parse($this->startedAt);
        $this->endedAt = Carbon::parse($this->endedAt);
    }
}