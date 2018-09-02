<?php

namespace App\OhDear;

class Site extends \OhDear\PhpSdk\Resources\Site
{

    public function __construct(array $attributes, $ohDear = null)
    {
        parent::__construct($attributes, $ohDear);

        $this->checks = collect($this->checks)->map(function ($check) {
            return new Check($check->attributes, $this->ohDear);
        });
    }

    public function getResume()
    {
        return $this->isUp()
            ? "✅ {$this->sortUrl} - site is up! 💪"
            : "🔴 {$this->sortUrl} - site is down! 😱";
    }

    public function getInformation()
    {
        return collect($this->checks)->map(function (Check $check) {

            if (! $check->enabled) {
                return null;
            }

            return "{$check->getResultAsIcon()} {$check->getTypeAsTitle()}";

        })->filter()->implode(PHP_EOL);
    }

    public function isUp()
    {
        return $this->summarizedCheckResult === 'succeeded';
    }
}