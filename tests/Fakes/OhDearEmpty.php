<?php

namespace Tests\Fakes;

use App\OhDear\Site;
use Illuminate\Support\Collection;

class OhDearEmpty extends OhDear
{

    public function sites(): Collection
    {
        return $this->collect(
            [],
            Site::class
        );
    }

}