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
            ->receives('webhooksecret');

        $user = User::first();

        $this->bot->assertReply(trans('ohdear.webhook.stored', ['url' => $user->getWebhookUrl()]));

        $this->assertNotEquals('tokensecret', $user->token);
        $this->assertEquals('tokensecret', decrypt($user->token));

        $this->assertNotEquals('webhooksecret', $user->webhook);
        $this->assertEquals('webhooksecret', decrypt($user->webhook));
    }

    /** @test */
    public function start_command_does_not_work_if_its_already_configured()
    {
        factory(User::class)->create(['telegram_id' => 'ohdearapp', 'token' => '123']);

        $this->bot->setUser(['id' => 'ohdearapp'])
            ->receives('/start')
            ->assertReply(trans('ohdear.greetings'))
            ->assertReply(trans('ohdear.already_set_up'));
    }
}