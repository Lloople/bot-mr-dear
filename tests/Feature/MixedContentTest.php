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
            ->assertReply(trans('ohdear.mixedcontent.result', [
                'url' => 'http://example.com/nonsecureimg.jpg',
                'origin' => 'https://example.com',
            ]))
            ->assertReply(trans('ohdear.mixedcontent.result', [
                'url' => 'http://example.iframe.com',
                'origin' => 'https://example.com/iframe',
            ]));
    }

    /** @test */
    public function can_get_a_message_when_there_are_no_mixed_content()
    {

        $this->bot->receives('/mixedcontent 1111')
            ->assertReply(trans('ohdear.mixedcontent.perfect'));
    }
}