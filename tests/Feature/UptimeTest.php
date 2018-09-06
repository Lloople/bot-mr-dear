<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UptimeTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function can_skip_first_uptime_if_it_was_perfect()
    {
        $this->bot->receives('/uptime https://months.example.com')
            ->assertReply(trans('ohdear.uptime.result', [
                'percentage' => '90',
                'date' => now()->subDay()->subMonths(5),
                'emoji' => '🎉',
            ]));
    }

    /** @test */
    public function can_see_a_perfect_uptime()
    {
        $this->bot->receives('/uptime https://weeks.example.com')
            ->assertReply(trans('ohdear.uptime.perfect', [
                'begin' => now()->subDays(28),
                'end' => now()->subDays(22),
            ]));
    }

    /** @test */
    public function can_show_lower_emoji_if_percentage_is_closer()
    {
        $this->bot->receives('/uptime https://days.example.com')
            ->assertReply(trans('ohdear.uptime.result', [
                'percentage' => '62',
                'date' => now()->subDays(4),
                'emoji' => '😕',
            ]));
    }
}