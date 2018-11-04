<?php

return [
    'greetings' => 'Hello there! 👋',
    'already_set_up' => 'You have completed the setup already. If you need to change any of your configuration, use /token {token} or /webhook {secret}.',
    'sites' => [
        'list_message' => 'Choose a site to interact with.',
        'list_empty' => 'There are no sites on your account. Perhaps you want to add a new one right now? use the command /newsite',
        'not_found' => 'You\'re not currently monitoring this site.',
        'created' => '👍 Oh Dear is now monitoring your site. All checks have been enabled by default.',
        'invalid_url' => 'Sorry, I cannot say that\'s a valid url. Example: https://example.com',
        'already_exists' => 'You\'re already monitoring that url 😅',
        'delete_confirm_1' => '⚠️ Are you sure you want to stop monitoring this site? All history data will be lost and this step cannot be undone.',
        'delete_confirm_2' => 'I\'ll proceed to delete the site *https://example.com*. Are you totally sure you want to continue?',
        'delete_cancel' => 'Alright, we will keep monitoring the site a bit longer 🙂',
        'deleted' => 'I deleted the site. You\'re no longer monitoring it.',
        'next_action' => 'What do you want to do next?',
    ],
    'token' => [
        'question' => 'I see you have no token configured, can you send it to me? I\'ll save it encrypted don\'t worry.',
        'stored' => 'Thank you for trusting me! You can delete the token message now for more security',
    ],
    'uptime' => [
        'result' => 'Your site had a :percentage% of uptime on :date :emoji',
        'perfect' => 'Your site had a perfect uptime from :begin to :end! 🙌'
    ],
    'downtime' => [
        'result' => 'Your website was down for :downtime on :date',
        'perfect' => 'Your site was up all the time during the last month! 🎉',
        'summary' => 'The last time your site was down was :elapsed ago :emoji'
    ],
    'brokenlinks' => [
        'perfect' => 'Your site has no broken links! 🙌',
        'result' => 'The url :url returned a :code error'.PHP_EOL.'It was found on :origin'
    ],
    'mixedcontent' => [
        'perfect' => 'Your site has no mixed content! 🙌',
        'result' => ':url'.PHP_EOL.'Was found on :origin'
    ],
    'help' => [
        'title' => 'Looks like you\'re a bit lost, let me help you out 😉'
    ],
    'webhook' => [
        'question' => 'I see you have no webhook configured. This is required if you want me to warn you if any of your sites have any issue. You can find your webhook secret in the bottom of the [Notifications](https://ohdear.app/team-settings/notifications) section.',
        'stored' => 'Remember to add the url :url to your [OhDear Notifications](https://ohdear.app/team-settings/notifications). I\'ll let you know if any of your sites has any problem 👍'
    ]
];