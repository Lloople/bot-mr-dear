<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebhookTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function can_configure_user_webhooks()
    {

        $this->bot->receives('/webhook 123456')
            ->assertReply(trans('ohdear.webhook.stored'));

        $user = User::first();

        $this->assertNotEquals('123456', $user->webhook);
        $this->assertEquals('123456', decrypt($user->webhook));
    }

}