<?php

namespace Tests\Fakes;

use App\OhDear\BrokenLink;
use App\OhDear\MixedContent;
use App\OhDear\Downtime;
use App\OhDear\Site;
use App\OhDear\Uptime;
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
        return json_decode(file_get_contents(base_path('tests/Fakes/responses/sites_list.json')), true)['data'];
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
            return stripos($site->url, $url) !== false;
        }, null);
    }

    public function deleteSite($siteId)
    {
        $this->sites = $this->sites->reject(function (Site $site) use ($siteId) {
            return $site->id === $siteId;
        });

        return ! $this->sites->firstWhere('id', $siteId);
    }

    public function getSiteDowntime($siteId)
    {
        $downtimes = include base_path('tests/Fakes/responses/downtimes.php');

        return $this->collect(json_decode(json_encode($downtimes[$siteId]), true), Downtime::class);
    }

    public function getSiteUptime($siteId)
    {
        $uptimes = include base_path('tests/Fakes/responses/uptimes.php');

        return $this->collect(json_decode(json_encode($uptimes[$siteId]), true), Uptime::class);
    }

    public function getBrokenLinks($siteId)
    {
        $brokenLinks = [
            [
                'crawledUrl' => 'https://example.com/broken',
                'statusCode' => 404,
                'foundOnUrl' => 'https://example.com',
            ],
            [
                'crawledUrl' => 'https://example.com/backend',
                'statusCode' => 403,
                'foundOnUrl' => 'https://example.com',
            ],
        ];

        return $this->collect($brokenLinks, BrokenLink::class);
    }

    public function getMixedContent($siteId)
    {
        $mixedContent = [
            [
                'elementName' => 'img',
                'mixedContentUrl' => 'http://example.com/nonsecureimg.jpg',
                'foundOnUrl' => 'https://example.com',
            ],
            [
                'elementName' => 'iframe',
                'mixedContentUrl' => 'http://example.iframe.com',
                'foundOnUrl' => 'https://example.com/iframe',
            ],
        ];

        return $this->collect($mixedContent, MixedContent::class);
    }
}