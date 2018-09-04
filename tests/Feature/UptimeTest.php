<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class UptimeTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function can_skip_first_uptime_if_it_was_perfect()
    {
        $this->bot->receives('/uptime https://months.example.com')
            ->assertReply('Your site had a 90% of uptime on '.now()->subDay()->subMonths(5).' 🎉');
    }

    /** @test */
    public function can_see_a_perfect_uptime()
    {
        $this->bot->receives('/uptime https://weeks.example.com')
            ->assertReply('Your site had a perfect uptime from '.now()->subDays(28).' to '.now()->subDays(22).'! 🙌');
    }

    /** @test */
    public function can_show_lower_emoji_if_percentage_is_closer()
    {
        $this->bot->receives('/uptime https://days.example.com')
            ->assertReply('Your site had a 62% of uptime on '.now()->subDays(4).' 😕');
    }
}