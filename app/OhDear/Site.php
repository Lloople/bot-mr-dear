<?php

namespace App\OhDear;

class Site
{

    public function __construct($payload)
    {
        $this->id = $payload->id;
        $this->url = $payload->url;
        $this->sort_url = $payload->sort_url;
        $this->team_id = $payload->team_id;
        $this->latest_run_date = $payload->latest_run_date;
        $this->summarized_check_result = $payload->summarized_check_result;
        $this->uses_https = $payload->uses_https;
        $this->checks = $payload->checks;

    }

    public function getResume()
    {
        return $this->isUp()
            ? "✅ {$this->sort_url} - site is up! 💪"
            : "🔴 {$this->sort_url} - site is down! 😱";
    }

    public function isUp()
    {
        return $this->summarized_check_result === 'succeeded';
    }
}