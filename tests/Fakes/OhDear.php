<?php

namespace Tests\Fakes;

use App\OhDear\Site;

class OhDear extends \App\OhDear\Services\OhDear
{

    public function getSites()
    {
        return $this->collect(
            json_decode(
                file_get_contents(
                    base_path('tests/Fakes/responses/sites_list.json')
                ),
                true
            )['data'],
            Site::class
        );
    }
}