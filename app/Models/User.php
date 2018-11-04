<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getToken()
    {
        return decrypt($this->token);
    }

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function getWebhookUrl()
    {
        return url('webhook') . '/' . auth()->user()->username;
    }
}
