<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StartConversationTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function can_store_token_and_webhook()
    {
        $this->bot->receives('/start')
            ->assertReply(trans('ohdear.greetings'))
            ->assertReply(trans('ohdear.token.question'))
            ->receives('tokensecret')
            ->assertReply(trans('ohdear.token.stored'))
            ->assertReply(trans('ohdear.webhook.question'))
            ->receives('webhooksecret')
            ->assertReply(trans('ohdear.webhook.stored'));

        $user = User::first();

        $this->assertNotEquals('tokensecret', $user->token);
        $this->assertEquals('tokensecret', decrypt($user->token));

        $this->assertNotEquals('webhooksecret', $user->webhook);
        $this->assertEquals('webhooksecret', decrypt($user->webhook));
    }
}