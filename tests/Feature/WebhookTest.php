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
        $this->bot->receives('/webhook secret');

        $this->assertEquals('secret', decrypt(User::first()->webhook));
    }

}