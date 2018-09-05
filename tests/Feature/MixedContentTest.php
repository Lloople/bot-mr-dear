<?php

namespace Tests\Feature;

use App\OhDear\Services\OhDear;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Fakes\OhDearEmpty;
use Tests\TestCase;

class MixedContentTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function can_get_a_list_of_mixed_content_for_a_site()
    {
        $this->bot->receives('/mixedcontent example')
            ->assertReply('http://example.com/nonsecureimg.jpg'.PHP_EOL.'Was found on https://example.com')
            ->assertReply('http://example.iframe.com'.PHP_EOL.'Was found on https://example.com/iframe');
    }

    /** @test */
    public function can_get_a_message_when_there_are_no_mixed_content()
    {
        $this->app->bind(OhDear::class, OhDearEmpty::class);

        $this->bot->receives('/mixedcontent example')
            ->assertReply('Your site has no mixed content! 🙌');
    }
}