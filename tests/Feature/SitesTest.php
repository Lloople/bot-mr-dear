<?php

namespace Tests\Feature;

use App\Exceptions\SiteNotFoundException;
use App\OhDear\Services\OhDear;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Fakes\OhDearEmpty;
use Tests\TestCase;

class SitesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_show_list_of_sites()
    {
        $this->bot->receives('/sites')
            ->assertQuestion(trans('ohdear.sites.list_message'));
    }

    /** @test */
    public function can_say_there_are_no_sites()
    {
        $this->app->bind(OhDear::class, OhDearEmpty::class);

        $this->bot->receives('/sites')
            ->assertReply(trans('ohdear.sites.list_empty'));
    }

    /** @test */
    public function incorrect_url_gets_rejected()
    {
        $this->bot->receives('/newsite new.example.com')
            ->assertReply(trans('ohdear.sites.invalid_url'));
    }

    /** @test */
    public function can_create_a_new_site()
    {
        $this->bot->receives('/newsite https://new.example.com')
            ->assertReply(trans('ohdear.sites.created'));
    }

    /** @test */
    public function cannot_create_a_site_with_already_in_use_url()
    {
        $this->bot->receives('/newsite https://example.com')
            ->assertReply(trans('ohdear.sites.already_exists'));
    }

    /** @test */
    public function can_show_a_site()
    {
        $this->bot->receives('/site https://example.com')
            ->assertReply('✅ example.com');
    }

    /** @test */
    public function emoji_change_if_site_is_down()
    {
        $this->bot->receives('/site http://failed.example.com')
            ->assertReply('🔴 failed.example.com');
    }

    /** @test */
    public function can_show_a_site_by_domain()
    {
        $this->bot->receives('/site example')
            ->assertReply('✅ example.com');
    }

    /** @test */
    public function can_show_a_site_by_id()
    {
        $this->bot->receives('/site 9999')
            ->assertReply('✅ example.com');
    }

    /** @test */
    public function can_display_a_message_with_missing_site()
    {
        $this->expectException(SiteNotFoundException::class);

        $this->bot->receives('/site https://new.example.com')
            ->assertReply(trans('ohdear.sites.not_found'));
    }

    /** @test */
    public function can_delete_a_site()
    {
        $this->assertNotNull(app(OhDear::class)->findSiteByUrl('https://example.com'));

        $this->bot->receives('/deletesite https://example.com')
            ->assertQuestion(trans('ohdear.sites.delete_confirm_1'))
            ->receivesInteractiveMessage(true)
            ->assertQuestion(trans('ohdear.sites.delete_confirm_2'))
            ->receivesInteractiveMessage(true)
            ->assertReply(trans('ohdear.sites.deleted'));

        $this->assertNull(app(OhDear::class)->findSiteByUrl('https://example.com'));
    }
}
