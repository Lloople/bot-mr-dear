<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class StartConversation extends Conversation
{
    public function run()
    {
        $this->bot->reply(trans('ohdear.greetings'));

        if (! auth()->user()->token) {
            $this->askToken();
        } else {
            $this->bot->reply(trans('ohdear.token.already_exists'));
        }
    }

    public function askToken()
    {
        $this->ask(trans('ohdear.token.question'), function (Answer $answer) {

            $token = $answer->getText();

            auth()->user()->token = encrypt($token);
            auth()->user()->save();

            $this->bot->reply(trans('ohdear.token.stored'));
        });
    }

}