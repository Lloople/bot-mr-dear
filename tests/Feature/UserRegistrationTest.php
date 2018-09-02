<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function can_store_encrypted_token()
    {
        $this->bot->receives('/start')
            ->assertReply('Hello there! 👋')
            ->assertReply('I see you have no token configured, can you send it to me? I\'ll save it encrypted don\'t worry.')
            ->receives('1234567890asdf')
            ->assertReply('Thank you for trusting me! You can delete the token message now for more security');

        $user = User::first();

        $this->assertNotEquals('1234567890asdf', $user->token);
        $this->assertEquals('1234567890asdf', decrypt($user->token));
    }
}
