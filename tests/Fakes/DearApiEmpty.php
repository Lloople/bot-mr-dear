<?php

namespace Tests\Fakes;

class DearApiEmpty extends \App\OhDear\Services\DearApi
{

    /**
     * @return array|mixed
     */
    public function getSitesList()
    {
        return [];
    }
}