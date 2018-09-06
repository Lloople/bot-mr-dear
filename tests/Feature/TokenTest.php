<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TokenTest extends TestCase
{

    use RefreshDatabase;


    /** @test */
    public function can_store_encrypted_token()
    {
        $this->bot->receives('/start')
            ->assertReply(trans('ohdear.greetings'))
            ->assertReply(trans('ohdear.token.question'))
            ->receives('1234567890asdf')
            ->assertReply(trans('ohdear.token.stored'));

        $user = User::first();

        $this->assertNotEquals('1234567890asdf', $user->token);
        $this->assertEquals('1234567890asdf', decrypt($user->token));
    }

    /** @test */
    public function user_can_change_its_token()
    {
        $this->bot->receives('/token secret')
            ->assertReply(trans('ohdear.token.stored'));

        $this->assertEquals('secret', User::first()->getToken());
    }
}