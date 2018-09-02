<?php

namespace Tests\Fakes;

use App\OhDear\Site;
use Illuminate\Support\Collection;

class OhDear extends \App\OhDear\Services\OhDear
{

    /** @var Collection */
    private $sites;

    public function __construct()
    {
        $this->sites = $this->collect($this->getFakeSites(), Site::class);
    }

    private function getFakeSites()
    {
        return json_decode(file_get_contents(base_path('tests/Fakes/responses/sites_list.json')),true)['data'];
    }

    public function sites(): Collection
    {
        return $this->sites;
    }

    public function createSite(string $url): Site
    {
        $siteData = $this->getFakeSites()[0];

        $siteData['url'] = $this->validatedUrl($url);

        $siteData['sort_url'] = str_replace('http://', '', $siteData['url']);
        $siteData['sort_url'] = str_replace('https://', '', $siteData['sort_url']);

        return new Site($siteData, $this);
    }

    public function findSiteByUrl(string $url): ?Site
    {
        return $this->sites->first(function (Site $site) use ($url) {
            return $site->url === $url;
        }, null);
    }

    public function deleteSite($siteId)
    {
        $this->sites = $this->sites->reject(function (Site $site) use ($siteId) {
            return $site->id === $siteId;
        });

        return ! $this->sites->firstWhere('id', $siteId);
    }
}