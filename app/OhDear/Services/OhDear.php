<?php

namespace App\OhDear\Services;

use App\Exceptions\InvalidUrlException;
use App\Exceptions\SiteNotFoundException;
use App\Helpers\Str;
use App\OhDear\BrokenLink;
use App\OhDear\Downtime;
use App\OhDear\MixedContent;
use App\OhDear\Site;
use App\OhDear\Uptime;
use Illuminate\Support\Collection;
use OhDear\PhpSdk\Exceptions\NotFoundException;
use OhDear\PhpSdk\MakesHttpRequests;

class OhDear
{

    use MakesHttpRequests;

    /** @var \OhDear\PhpSdk\OhDear */
    private $ohDear;

    public function __construct()
    {
        $this->ohDear = new \OhDear\PhpSdk\OhDear(auth()->user()->getToken(), null);

        $this->client = $this->ohDear->client;
    }

    public function sites(): Collection
    {
        return $this->collect($this->get('sites')['data'], Site::class);
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

            $site = Str::validate_url($url)
                ? $this->get("sites/url/{$url}")
                : $this->searchSiteByUrl($url);

            return new Site($site, $this);

        } catch (NotFoundException $e) {

            return null;

        }
    }

    private function searchSiteByUrl(string $url): Site
    {
        return $this->sites()->first(function (Site $site) use ($url) {
            return stripos($site->url, $url) !== false;
        }, function () {
            throw new NotFoundException();
        });
    }

    /**
     * @param $id
     *
     * @return \App\OhDear\Site
     * @throws \App\Exceptions\SiteNotFoundException
     */
    public function findSite($id): Site
    {
        try {
            if (is_numeric($id)) {
                return new Site($this->get("sites/{$id}"), $this);
            } elseif (Str::validate_url($id)) {
                return new Site($this->get("sites/url/{$id}"), $this);
            }

            return $this->searchSiteByUrl($id);

        } catch (NotFoundException $e) {

            throw new SiteNotFoundException();

        }
    }

    public function deleteSite($siteId)
    {
        return $this->ohDear->delete("sites/{$siteId}");
    }

    public function getSiteDowntime($siteId)
    {
        return $this->collect($this->get("sites/{$siteId}/downtime{$this->getDefaultStartedEndedFilter()}")['data'],
            Downtime::class);
    }

    public function getSiteUptime($siteId)
    {
        return $this->collect($this->get("sites/{$siteId}/uptime{$this->getDefaultStartedEndedFilter()}&split=day"),
            Uptime::class);
    }

    public function getBrokenLinks($siteId)
    {
        return $this->collect($this->get("broken-links/{$siteId}")['data'], BrokenLink::class);
    }

    public function getMixedContent($siteId)
    {
        return $this->collect($this->get("mixed-content/{$siteId}")['data'], MixedContent::class);
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
        return "?filter[started_at]=" . now()->subDays(30)->format('YmdHis') . "&filter[ended_at]=" . date('YmdHis');
    }
}