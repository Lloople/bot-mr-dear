<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DowntimeTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function can_see_sites_downtime_in_months()
    {
        $this->bot->receives('/downtime https://months.example.com')
            ->assertReply('The last time your site was down was 3 months ago 🎉');
    }

    /** @test */
    public function can_see_sites_downtime_in_weeks()
    {
        $this->bot->receives('/downtime https://weeks.example.com')
            ->assertReply('The last time your site was down was 3 weeks ago 🙌');
    }

    /** @test */
    public function can_see_sites_downtime_in_days()
    {
        $this->bot->receives('/downtime https://days.example.com')
            ->assertReply('The last time your site was down was 3 days ago 👍');
    }

    /** @test */
    public function can_see_sites_downtime_in_hours()
    {
        $this->bot->receives('/downtime https://hours.example.com')
            ->assertReply('The last time your site was down was 7 hours ago 😕');
    }

    /** @test */
    public function can_see_sites_downtime_in_minutes()
    {
        $this->bot->receives('/downtime https://minutes.example.com')
            ->assertReply('The last time your site was down was 30 minutes ago 😞');
    }
}