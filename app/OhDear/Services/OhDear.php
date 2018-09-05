<?php

namespace App\OhDear\Services;

use App\Exceptions\InvalidUrlException;
use App\Helpers\Str;
use App\OhDear\BrokenLink;
use App\OhDear\Downtime;
use App\OhDear\Site;
use App\OhDear\Uptime;
use Illuminate\Support\Collection;
use OhDear\PhpSdk\Exceptions\NotFoundException;

class OhDear
{

    /** @var \OhDear\PhpSdk\OhDear */
    private $ohDear;

    public function __construct()
    {
        $token = auth()->user()->getToken();

        $this->ohDear = new \OhDear\PhpSdk\OhDear($token, null);
    }

    public function sites(): Collection
    {
        return $this->collect($this->ohDear->get('sites')['data'], Site::class);
    }

    /**
     * @param string $url
     *
     * @return \App\OhDear\Site
     * @throws \App\Exceptions\InvalidUrlException
     */
    public function createSite(string $url): Site
    {
        $site = $this->ohDear->post('sites', ['url' => $this->validatedUrl($url)]);

        return new Site($site, $this);
    }

    /**
     * @param string $url
     *
     * @return \App\OhDear\Site|null
     */
    public function findSiteByUrl(string $url): ?Site
    {
        try {

            if (! Str::validate_url($url)) {
                return $this->ohDear->sites()->first(function (Site $site) use ($url) {
                    return stripos($site->url, $url) !== false;
                }, function () { throw new NotFoundException(); });
            }

            return $this->ohDear->get("sites/url/{$url}");

        } catch (NotFoundException $e) {

            return null;

        }
    }

    public function deleteSite($siteId)
    {
        return $this->ohDear->delete("sites/{$siteId}");
    }

    public function getSiteDowntime($siteId)
    {
        return $this->collect($this->ohDear->get("sites/{$siteId}/downtime{$this->getDefaultStartedEndedFilter()}"), Downtime::class);
    }

    public function getSiteUptime($siteId)
    {
        return $this->collect($this->ohDear->get("sites/{$siteId}/uptime{$this->getDefaultStartedEndedFilter()}"), Uptime::class);
    }

    public function getBrokenLinks($siteId)
    {
        return $this->collect($this->ohDear->get("broken-links/{$siteId}"), BrokenLink::class);
    }

    public function collect($collection, $class)
    {
        return collect($collection)->map(function ($attributes) use ($class) {
            return new $class($attributes, $this);
        });
    }

    /**
     * @param string $url
     *
     * @return string
     * @throws \App\Exceptions\InvalidUrlException
     */
    protected function validatedUrl(string $url)
    {
        if (! Str::validate_url($url)) {
            throw new InvalidUrlException;
        }

        return $url;
    }

    private function getDefaultStartedEndedFilter()
    {
        return "?filter[started_at]=".now()->subDays(30)->format('YmdHis')."&filter[ended_at]=".date('YmdHis');
    }
}