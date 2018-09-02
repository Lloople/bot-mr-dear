<?php

namespace App\OhDear\Services;

use App\Exceptions\InvalidUrlException;
use App\OhDear\Site;
use Illuminate\Support\Collection;
use OhDear\PhpSdk\Exceptions\NotFoundException;

class OhDear
{

    public function __construct()
    {
        $token = ''; // TODO: Get this token from the configuration set by the user.

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

    public function getSiteByUrl(string $url): ?Site
    {
        try {

            return $this->ohDear->get("sites/url/{$this->validatedUrl($url)}");

        } catch (NotFoundException $e) {

            return null;

        }
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
        $regex = '/(https?:\/\/www\.|https?:\/\/)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?/';

        if (! preg_match($regex, $url)) {
            throw new InvalidUrlException;
        }

        return $url;
    }
}