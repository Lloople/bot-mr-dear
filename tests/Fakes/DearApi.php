<?php

namespace Tests\Fakes;

class DearApi extends \App\OhDear\Services\DearApi
{

    /**
     * @return array|mixed
     */
    public function getSitesList()
    {
        return json_decode(
            file_get_contents(
                base_path('tests/Fakes/responses/sites_list.json')
            )
        );
    }
}