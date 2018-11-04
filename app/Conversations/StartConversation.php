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
            $this->bot->reply(trans('ohdear.already_set_up'));
        }
    }

    public function askToken()
    {
        $this->ask(trans('ohdear.token.question'), function (Answer $answer) {

            auth()->user()->token = encrypt($answer->getText());
            auth()->user()->save();

            $this->bot->reply(trans('ohdear.token.stored'));

            $this->askWebhook();
        });
    }

    public function askWebhook()
    {
        $this->ask(trans('ohdear.webhook.question'), function (Answer $answer) {

            auth()->user()->webhook = encrypt($answer->getText());
            auth()->user()->save();

            $this->bot->reply(trans('ohdear.webhook.stored'), ['parse_mode' => 'Markdown']);
        }, ['parse_mode' => 'Markdown']);
    }

}