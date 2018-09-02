<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use Illuminate\Contracts\Auth\Authenticatable;

class UserStoreConversation extends Conversation
{

    const MESSAGE_TOKEN = 'I see you have no token configured, can you send it to me? I\'ll save it encrypted don\'t worry.';
    const MESSAGE_TOKEN_EXISTS = 'You already have a token defined, use /token {token} if you want to change it';
    const MESSAGE_THANKS = 'Thank you for trusting me! You can delete the token message now for more security';

    /** @var \Illuminate\Contracts\Auth\Authenticatable  */
    private $user;

    public function __construct(Authenticatable $user)
    {
        $this->user = $user;
    }

    public function run()
    {
        $this->bot->reply('Hello there! 👋');

        if (! $this->user->token) {
            $this->askToken();
        } else {
            $this->bot->reply(self::MESSAGE_TOKEN_EXISTS);
        }
    }

    public function askToken()
    {
        $this->ask(self::MESSAGE_TOKEN, function (Answer $answer) {

            $token = $answer->getText();

            $this->user->token = encrypt($token);
            $this->user->save();

            $this->bot->reply(self::MESSAGE_THANKS);
        });
    }

}