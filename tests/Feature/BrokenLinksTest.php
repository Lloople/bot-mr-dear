<?php

namespace Tests\Feature;

use App\OhDear\Services\OhDear;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Fakes\OhDearEmpty;
use Tests\TestCase;

class BrokenLinksTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function can_get_a_list_of_broken_list_for_a_site()
    {
        $this->bot->receives('/brokenlinks example')
            ->assertReply('The url https://example.com/broken returned a 404 error' . PHP_EOL . 'It was found on https://example.com')
            ->assertReply('The url https://example.com/backend returned a 403 error' . PHP_EOL . 'It was found on https://example.com');
    }

    /** @test */
    public function can_get_a_message_when_there_are_no_broken_links()
    {
        $this->app->bind(OhDear::class, OhDearEmpty::class);

        $this->bot->receives('/brokenlinks example')
            ->assertReply('Your site has no broken links! 🙌');
    }
}