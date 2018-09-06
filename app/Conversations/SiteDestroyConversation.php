<?php

namespace App\Conversations;

use App\OhDear\Services\OhDear;
use App\OhDear\Site;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class SiteDestroyConversation extends Conversation
{
    /** @var \App\OhDear\Site  */
    private $site;

    /** @var \App\OhDear\Services\OhDear  */
    private $dear;


    public function __construct(OhDear $dear, Site $site)
    {
        $this->dear = $dear;
        $this->site = $site;
    }

    public function run()
    {
        $this->askFirstConfirmation();
    }

    public function askFirstConfirmation()
    {
        $this->ask($this->getQuestion(trans('ohdear.sites.delete_confirm_1')), function (Answer $answer) {

            $nextStep = $answer->isInteractiveMessageReply()
                ? $answer->getValue()
                : $this->answerToBoolean($answer->getText());

            if (! $nextStep) {
                $this->bot->reply(trans('ohdear.sites.delete_cancel'));

                return;
            }

            $this->askSecondConfirmation();

        });
    }

    private function getQuestion(string $message): Question
    {
        return Question::create($message)
            ->fallback('Unable to delete the site, please try again later.')
            ->addButtons([
                Button::create('Yes')->value(true),
                Button::create('No')->value(false),
            ]);
    }

    public function askSecondConfirmation()
    {
        $this->ask($this->getQuestion(trans('ohdear.sites.delete_confirm_2')), function (Answer $answer) {

            $nextStep = $answer->isInteractiveMessageReply()
                ? $answer->getValue()
                : $this->answerToBoolean($answer->getText());

            if (! $nextStep) {
                $this->bot->reply(trans('ohdear.sites.delete_cancel'));

                return;
            }

            $this->site->delete();

            $this->bot->reply(trans('ohdear.sites.deleted'));
        });
    }

    public function answerToBoolean(string $answer)
    {
        $positiveMessages = ['true', 'yes', 'of course', 'yeah', 'affirmative', 'i confirm'];

        return in_array(strtolower($answer), $positiveMessages);
    }

}