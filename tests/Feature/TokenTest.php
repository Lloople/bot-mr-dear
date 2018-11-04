<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TokenTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function user_can_change_its_token()
    {
        $this->bot->receives('/token secret')
            ->assertReply(trans('ohdear.token.stored'));

        $this->assertEquals('secret', User::first()->getToken());
    }
}