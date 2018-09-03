<?php

namespace App\Helpers;

class Str
{

    public static function isValidUrl($url)
    {
        $regex = '/(https?:\/\/www\.|https?:\/\/)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?/';

        return preg_match($regex, $url) === 1;
    }

    public static function getElapsedTime($date)
    {
        foreach (['months', 'weeks', 'days', 'hours', 'minutes', 'seconds'] as $interval) {
            $elapsedTime = $date->{'diffIn'.ucfirst($interval)}();

            if ($elapsedTime) {
                return [
                    'diff' => $elapsedTime,
                    'interval' => $interval
                ];
            }
        }
    }
}