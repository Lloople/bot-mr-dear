<?php


namespace App\OhDear;


class Site extends \OhDear\PhpSdk\Resources\Site
{

    public function getResume()
    {
        return $this->isUp()
            ? "✅ {$this->sortUrl} - site is up! 💪"
            : "🔴 {$this->sortUrl} - site is down! 😱";
    }

    public function isUp()
    {
        return $this->summarizedCheckResult === 'succeeded';
    }
}