<?php

namespace App\OhDear;

use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class Site extends \OhDear\PhpSdk\Resources\Site
{

    public function __construct(array $attributes, $ohDear = null)
    {
        parent::__construct($attributes, $ohDear);

        $this->checks = collect($this->checks)->map(function ($check) {
            return new Check($check->attributes, $this->ohDear);
        });
    }

    public function getResume()
    {
        return "{$this->getStatusEmoji()} {$this->sortUrl}";
    }

    public function getInformation()
    {
        return "{$this->getStatusEmoji()} {$this->sortUrl}"
            . PHP_EOL
            . collect($this->checks)->map(function (Check $check) {

                if (! $check->enabled) {
                    return null;
                }

                return "{$check->getResultAsIcon()} {$check->getTypeAsTitle()}";

            })->filter()->implode(PHP_EOL);
    }

    public function getKeyboard()
    {
        return (new Question('Actions'))
            ->addButtons([
                Button::create('Uptime')->value("/uptime {$this->id}"),
                Button::create('Downtime')->value("/downtime {$this->id}"),
                Button::create('Broken Links')->value("/brokenlinks {$this->id}"),
                Button::create('Mixed Content')->value("/mixedcontent {$this->id}"),
            ]);
    }

    public function isUp()
    {
        return $this->summarizedCheckResult === 'succeeded';
    }

    public function delete()
    {
        return $this->ohDear->deleteSite($this->id);
    }

    public function getStatusEmoji()
    {
        return $this->isUp() ? "✅" : "🔴";
    }
}