<?php

return [
    '1111' => [
        [
            'datetime' => now()->subDay()->subMonths(3)->format('Y-m-d H:i:s'),
            'uptime_percentage' => 100,
        ],
        [
            'datetime' => now()->subDay()->subMonths(5)->format('Y-m-d H:i:s'),
            'uptime_percentage' => 90,
        ],

    ],
    '2222' => [
        [
            'datetime' => now()->subDays(22)->format('Y-m-d H:i:s'),
            'uptime_percentage' => 100,
        ],
        [
            'datetime' => now()->subDays(28)->format('Y-m-d H:i:s'),
            'uptime_percentage' => 100,
        ],
    ],
    '3333' => [
        [
            'datetime' => now()->subDays(4)->format('Y-m-d H:i:s'),
            'uptime_percentage' => 62,
        ],
        [
            'datetime' => now()->subDays(7)->format('Y-m-d H:i:s'),
            'uptime_percentage' => 90,
        ],
    ],
    '4444' => [
        [
            'datetime' => now()->subHours(8)->format('Y-m-d H:i:s'),
            'uptime_percentage' => 90,
        ],
        [
            'datetime' => now()->subHours(15)->format('Y-m-d H:i:s'),
            'uptime_percentage' => 90,
        ],

    ],
    '5555' => [
        [
            'datetime' => now()->subMinutes(34)->format('Y-m-d H:i:s'),
            'uptime_percentage' => 90,
        ],
        [
            'datetime' => now()->subMinutes(55)->subMonth()->format('Y-m-d H:i:s'),
            'uptime_percentage' => 90,
        ],
    ],
];