<?php

namespace App\Traits;

trait FindSites
{

    protected function find($siteIdOrUrl)
    {
        return is_numeric($siteIdOrUrl)
            ? $this->dear->findSite($siteIdOrUrl)
            : $this->dear->findSiteByUrl($siteIdOrUrl);
    }
}