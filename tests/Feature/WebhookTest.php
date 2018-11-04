<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebhookTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function can_configure_user_webhook()
    {
        $this->bot->receives('/webhook 123456')
            ->assertReply(trans('ohdear.webhook.stored'));

        $user = User::first();

        $this->assertEquals('123456', decrypt($user->webhook));
    }

}