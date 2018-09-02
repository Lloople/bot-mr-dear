<?php

namespace Tests\Feature;

use App\OhDear\Services\OhDear;
use Tests\Fakes\OhDearEmpty;
use Tests\TestCase;

class SitesTest extends TestCase
{
    /** @test */
    public function can_show_list_of_sites()
    {
        $this->bot->receives('/sites')
            ->assertReply('✅ example.com - site is up! 💪')
            ->assertReply('🔴 failed.example.com - site is down! 😱');
    }

    /** @test */
    public function can_say_there_are_no_sites()
    {
        $this->app->bind(OhDear::class, OhDearEmpty::class);

        $this->bot->receives('/sites')
            ->assertReply('There are no sites on your account.')
            ->assertReply('Perhaps you want to add a new one right now? use the command /newsite');
    }

    /** @test */
    public function incorrect_url_gets_rejected()
    {
        $this->bot->receives('/newsite new.example.com')
            ->assertReply('Sorry, I cannot say that\'s a valid url. Example: https://example.com');
    }

    /** @test */
    public function can_create_a_new_site()
    {
        $this->bot->receives('/newsite https://new.example.com')
            ->assertReply('👍 Oh Dear is now monitoring your site. All checks have been enabled by default.');
    }

    /** @test */
    public function can_show_a_site()
    {
        $this->bot->receives('/site https://example.com')
            ->assertReply('✅ example.com - site is up! 💪');
    }

    /** @test */
    public function can_display_a_message_with_missing_site()
    {
        $this->bot->receives('/site https://new.example.com')
            ->assertReply('You\'re not currently monitoring this site. Would you like to?')
            ->assertReply('/newsite https://new.example.com');
    }
}
