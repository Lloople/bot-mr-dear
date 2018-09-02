<?php

namespace App\Http\Middleware;

use App\Models\User;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Interfaces\Middleware\Received;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use Illuminate\Support\Facades\Hash;

class LoadUserMiddleware implements Received
{

    /**
     * Handle an incoming message.
     *
     * @param IncomingMessage $message
     * @param callable $next
     * @param BotMan $bot
     *
     * @return mixed
     */
    public function received(IncomingMessage $message, $next, BotMan $bot)
    {
        $botUser = $bot->getDriver()->getUser($message);

        $user = User::firstOrCreate([
            'telegram_id' => $botUser->getId(),
        ], [
            'name' => $botUser->getFirstName() ?? $botUser->getId(),
            'surname' => $botUser->getLastName(),
            'username' => $botUser->getUsername(),
            'email' => $botUser->getId() . '@ohdearbot.com',
            'password' => Hash::make($botUser->getUsername() . '-ohdearbot'),
        ]);

        auth()->login($user);

        return $next($message);
    }
}