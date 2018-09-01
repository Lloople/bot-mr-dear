<?php

namespace Tests\Fakes;

use App\OhDear\Site;

class OhDearEmpty extends \App\OhDear\Services\OhDear
{

    public function getSites()
    {
        return $this->collect(
            [],
            Site::class
        );
    }
}