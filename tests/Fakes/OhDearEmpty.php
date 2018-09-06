<?php

namespace Tests\Fakes;

use App\OhDear\Site;
use Illuminate\Support\Collection;

class OhDearEmpty extends OhDear
{

    public function sites(): Collection { return collect(); }

    public function getSiteDowntime($siteId) { return collect(); }

    public function getBrokenLinks($siteId) { return collect(); }

    public function getMixedContent($siteId) { return collect(); }

}