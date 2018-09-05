<?php

return [
    '1111' => [
        [
            'started_at' => now()->subDay()->subMonths(3)->format('Y-m-d H:i:s'),
            'ended_at' => now()->subDay()->subMonths(3)->addMinute()->addSeconds(34)->format('Y-m-d H:i:s'),
        ],
        [
            'started_at' => now()->subDay()->subMonths(5)->format('Y-m-d H:i:s'),
            'ended_at' => now()->subDay()->subMonths(5)->addHour()->format('Y-m-d H:i:s'),
        ],

    ],
    '2222' => [
        [
            'started_at' => now()->subDays(22)->format('Y-m-d H:i:s'),
            'ended_at' => now()->subDays(22)->addMinutes(8)->addSeconds(10)->format('Y-m-d H:i:s'),
        ],
        [
            'started_at' => now()->subDays(28)->format('Y-m-d H:i:s'),
            'ended_at' => now()->subDays(28)->addHour()->format('Y-m-d H:i:s'),
        ],
    ],
    '3333' => [
        [
            'started_at' => now()->subDays(4)->format('Y-m-d H:i:s'),
            'ended_at' => now()->subDays(2)->addHours(5)->addMinutes(3)->format('Y-m-d H:i:s'),
        ],
        [
            'started_at' => now()->subDays(7)->format('Y-m-d H:i:s'),
            'ended_at' => now()->subDays(7)->addHour()->format('Y-m-d H:i:s'),
        ],
    ],
    '4444' => [
        [
            'started_at' => now()->subHours(8)->format('Y-m-d H:i:s'),
            'ended_at' => now()->subHours(8)->addMinutes(6)->format('Y-m-d H:i:s'),
        ],
        [
            'started_at' => now()->subHours(15)->format('Y-m-d H:i:s'),
            'ended_at' => now()->subHours(14)->format('Y-m-d H:i:s'),
        ],

    ],
    '5555' => [
        [
            'started_at' => now()->subMinutes(34)->format('Y-m-d H:i:s'),
            'ended_at' => now()->subMinutes(34)->addSeconds(55)->format('Y-m-d H:i:s'),
        ],
        [
            'started_at' => now()->subMinutes(55)->subMonth()->format('Y-m-d H:i:s'),
            'ended_at' => now()->subMinutes(54)->format('Y-m-d H:i:s'),
        ],
    ],
];