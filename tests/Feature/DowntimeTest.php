<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class DowntimeTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function can_see_sites_downtime_in_months()
    {
        $this->bot->receives('/downtime https://months.example.com')
            ->assertReply('The last time your site was down was 3 months ago 🎉')
            ->assertReply('Your website was down for 1 minute and 34 seconds on '.$this->format(now()->subDay()->subMonths(3)));
    }

    /** @test */
    public function can_see_sites_downtime_in_weeks()
    {
        $this->bot->receives('/downtime https://weeks.example.com')
            ->assertReply('The last time your site was down was 3 weeks ago 🙌')
            ->assertReply('Your website was down for 8 minutes and 10 seconds on ' . $this->format(now()->subDays(22)));
    }

    /** @test */
    public function can_see_sites_downtime_in_days()
    {
        $this->bot->receives('/downtime https://days.example.com')
            ->assertReply('The last time your site was down was 1 day ago 👍')
            ->assertReply('Your website was down for 2 days, 5 hours and 3 minutes on '.$this->format(now()->subDays(4)));
    }

    /** @test */
    public function can_see_sites_downtime_in_hours()
    {
        $this->bot->receives('/downtime https://hours.example.com')
            ->assertReply('The last time your site was down was 7 hours ago 😕')
            ->assertReply('Your website was down for 6 minutes on '.$this->format(now()->subHours(8)));
    }

    /** @test */
    public function can_see_sites_downtime_in_minutes()
    {
        $this->bot->receives('/downtime https://minutes.example.com')
            ->assertReply('The last time your site was down was 33 minutes ago 😞')
            ->assertReply('Your website was down for 55 seconds on '.$this->format(now()->subMinutes(34)));
    }

    private function format(Carbon $date)
    {
        return $date->format('D, F d, Y');
    }
}