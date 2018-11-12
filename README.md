<p align="center"><img height="188" width="198" src="https://raw.githubusercontent.com/Lloople/bot-mr-dear/master/public/img/ohdear_avatar.png"></p>

<h1 align="center">Mr. Dear</h1>

I'm here to help you manage your sites on [Oh Dear! App](https://ohdear.app) by chat. Also I can text you if something is going wrong (Let's hope it'll be no need to 😉)

## Interacting with the bot

### Commands

- `/sites` - I'll show you a list with your current sites and their most recent status result.
- `/newsite {url}` - We will begin a delightful conversation in order to add a new site to your collection.
- `/deletesite {url or id}` - I get it, you don't want to see that site anymore, but first we will confirm you really want to do this.
- `/site {url or id}` - I'll be glad to show you all the information regarding to a specific site.
- `/downtime {url or id}` - Let's see how many times your site was down for the last month.
- `/uptime {url or id}` - I'll tell you the percentage your site was up on the last month.
- `/brokenlinks {url or id}` - Check out your website's broken links in a second.
- `/mixedcontent {url or id}` - Check out your website's mixed content.

### Action Buttons

Since the moment you ask me about your sites (`/sites`) I'll show you the name of your sites along with
an indicator to see quickly if it's online (✅ or 🔴) in form of a button. You can click it to see more 
information about your site and another group of buttons to check other common actions like Broken Links,
Downtime, etc... 

### Webhooks

During the `/start` process, the bot will ask you for your API token in order to interact with your sites, but also
your `webhook signing secret`. This information can be found at the end of the [Notifications page](https://ohdear.app/team-settings/notifications).

With this key configured, the bot can warn you if there's any problem with your site. Currently notifications supported are:
- Uptime Check Failed
- Broken Links Found

## Installation

This bot is currently functional at [MrDear_bot](http://t.me/MrDear_bot) on Telegram, so you don't have to do anything to
get up and running.

However, there's a chance you want to host it yourself to ensure your token is not stored in someone else's database. If that's
your case, just follow the few steps described below.

```
composer install
php artisan migrate
cp .env.example .env
```
### Registering the bot

After that, you will need to [create your own Telegram Bot](https://core.telegram.org/bots#3-how-do-i-create-a-bot).

Once you have obtained the access token, place it in your `.env` file like `TELEGRAM_TOKEN=token`.

Telegram needs to send the incoming messages to your bot. In order to configure that, you can use the following command

```
php artisan botman:telegram:register
```

The default url will be `yourdomain.com/botman`. It must `HTTPS`

> If you're developing in a local environment, take in mind using Laravel Valet feature `valet share`. It uses ngrok
> under the hood to make your project accessible from the outside. 

That's it. You can now talk to your bot.

### Troubleshooting

If your is not running as you've expected you have a few tools to see what's going on:

- If you're using `valet share` for local development you already have a custom dashboard to check incoming requests at http://127.0.0.1:4040
- To see the full error, check the `storage/logs/laravel.log` file. Take in mind that Telegram re-sends a failed request up to 4 more times.
- To debug the application, you can use [Beyond Code](https://github.com/beyondcode) package called `laravel-dump-server`. It's already installed
in this project, you just need to run `php artisan dump-server` and put some `dump($var)` in your code to see it in the terminal.
## Security Vulnerabilities

If you discover a security vulnerability within this bot, please send an e-mail to David Llop at d.lloople@icloud.com. All security vulnerabilities will be promptly addressed.

## License

Mr. Dear is free software distributed under the terms of the MIT license.