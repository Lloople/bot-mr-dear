<?php

namespace App\OhDear;

use Illuminate\Support\Carbon;
use OhDear\PhpSdk\Resources\ApiResource;

class Uptime extends ApiResource
{

    const PERCENTAGES_EMOJIS = [
        '🎉' => 100,
        '🙌' => 75,
        '😕' => 50,
        '😞' => 25,
        '😱' => 0,
    ];

    public function __construct(array $attributes, $ohDear = null)
    {
        parent::__construct($attributes, $ohDear);

        $this->datetime = Carbon::parse($this->datetime);
    }

    public function getPercentageEmoji()
    {
        foreach (self::PERCENTAGES_EMOJIS as $emoji => $cut) {

            if (abs($this->uptimePercentage - $cut) <= 12.5) {
                return $emoji;
            }
        }

        return '😱';
    }

}