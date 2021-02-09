<?php

namespace App\Settings;

use LaravelPropertyBag\Settings\ResourceConfig;

class WidgetSettings extends ResourceConfig
{
    /**
     * Registered settings for the user. Register settings by setting name. Each
     * setting must have an associative array set as its value that contains an
     * array of 'allowed' values and a single 'default' value.
     *
     * @var array
     */
    protected $registeredSettings = [
        'widget_view_type' => [
            'allowed' => [
                'marquee',
                'slider',
                'list',
            ],
            'default' => 'marquee',
        ],
        'align' => [
            'allowed' => [
                'left',
                'center',
                'right',
            ],
            'default' => 'left',
        ],
        'elements_count' => [
            'allowed' => ':range=1,50:',
            'default' => 5,
        ],
        'marquee_duration' => [
            'allowed' => ':int:',
            'default' => 10,
        ],
        'period' => [
            'allowed' => [
                'current_day',
                'current_week',
                'current_month',
                'current_year',
                'last_day',
                'last_week',
                'last_month',
                'last_year',
                'all_time',
            ],
            'default' => 'current_day',
        ],
        'slider_speed' => [
            'allowed' => ':int:',
            'default' => 10,
        ],
        'stats_type' => [
            'allowed' => [
                'donators',
                'donations',
                'latest',
            ],
            'default' => 'donations_top',
        ],
        'text_template' => [
            'allowed' => ':string:',
            'default' => '{ donation_sender } - { sum }',
        ],
        'title' => [
            'allowed' => ':any:',
            'default' => array(),
        ],
    ];
}
