<?php

namespace Tests\Feature;

use App\OhDear\Services\OhDear;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Fakes\OhDearEmpty;
use Tests\TestCase;

class DowntimeTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function can_see_perfect_uptime_message()
    {
        $this->app->bind(OhDear::class, OhDearEmpty::class);

        $this->bot->receives('/downtime https://months.example.com')
            ->assertReply(trans('ohdear.downtime.perfect'));
    }

    /** @test */
    public function can_see_sites_downtime_in_months()
    {
        $this->bot->receives('/downtime https://months.example.com')
            ->assertReply(trans('ohdear.downtime.summary', [
                'elapsed' => '3 months',
                'emoji' => '🎉'
            ]))
            ->assertReply(trans('ohdear.downtime.result', [
                'downtime' => '1 minute and 34 seconds',
                'date' => now()->subDay()->subMonths(3),
            ]));
    }

    /** @test */
    public function can_see_sites_downtime_in_weeks()
    {
        $this->bot->receives('/downtime https://weeks.example.com')
            ->assertReply(trans('ohdear.downtime.summary', [
                'elapsed' => '3 weeks',
                'emoji' => '🙌'
            ]))
            ->assertReply(trans('ohdear.downtime.result', [
                'downtime' => '8 minutes and 10 seconds',
                'date' => now()->subDays(22),
            ]));
    }

    /** @test */
    public function can_see_sites_downtime_in_days()
    {
        $this->bot->receives('/downtime https://days.example.com')
            ->assertReply(trans('ohdear.downtime.summary', [
                'elapsed' => '1 day',
                'emoji' => '👍'
            ]))
            ->assertReply(trans('ohdear.downtime.result', [
                'downtime' => '2 days, 5 hours and 3 minutes',
                'date' => now()->subDays(4),
            ]));
    }

    /** @test */
    public function can_see_sites_downtime_in_hours()
    {
        $this->bot->receives('/downtime https://hours.example.com')
            ->assertReply(trans('ohdear.downtime.summary', [
                'elapsed' => '7 hours',
                'emoji' => '😕'
            ]))
            ->assertReply(trans('ohdear.downtime.result', [
                'downtime' => '6 minutes',
                'date' => now()->subHours(8),
            ]));
    }

    /** @test */
    public function can_see_sites_downtime_in_minutes()
    {
        $this->bot->receives('/downtime https://minutes.example.com')
            ->assertReply(trans('ohdear.downtime.summary', [
                'elapsed' => '33 minutes',
                'emoji' => '😞'
            ]))
            ->assertReply(trans('ohdear.downtime.result', [
                'downtime' => '55 seconds',
                'date' => now()->subMinutes(34),
            ]));
    }
}