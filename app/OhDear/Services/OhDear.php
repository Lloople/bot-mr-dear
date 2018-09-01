<?php

namespace App\OhDear\Services;

use App\OhDear\Site;

class OhDear
{
    public function __construct(DearApi $api)
    {
        $this->api = $api;
    }

    public function getSitesList()
    {
        $response = $this->api->getSitesList();

        return collect($response->data ?? [])->map(function ($data) { return new Site($data); });
    }

}