<?php

namespace Tests\Fakes;

use App\OhDear\Site;
use Illuminate\Support\Collection;

class OhDear extends \App\OhDear\Services\OhDear
{

    private function getFakeSites()
    {
        return json_decode(
                   file_get_contents(
                       base_path('tests/Fakes/responses/sites_list.json')
                   ),
                   true
               )['data'];
    }

    public function sites(): Collection
    {
        return $this->collect($this->getFakeSites(), Site::class);
    }

    public function createSite(string $url): Site
    {
        $siteData = $this->getFakeSites()[0];

        $siteData['url'] = $this->validatedUrl($url);

        $siteData['sort_url'] = str_replace('http://', '', $siteData['url']);
        $siteData['sort_url'] = str_replace('https://', '', $siteData['sort_url']);

        return new Site($siteData, $this);
    }

    public function getSiteByUrl(string $url): ?Site
    {
        return $this->sites()->first(function (Site $site) use ($url) {
            return $site->url === $url;
        }, null);
    }
}