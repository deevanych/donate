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
            'allowed' => ['marquee', 'slider', 'list'],
            'default' => 'marquee',
        ],
        'align' => [
            'allowed' => ['left', 'center', 'right'],
            'default' => 'left',
        ],
        'elements_count' => [
            'allowed' => ':int:',
            'default' => 5,
        ],
        'marquee_duration' => [
            'allowed' => ':int:',
            'default' => 10,
        ],
        'period' => [
            'allowed' => ':string:',
            'default' => 'current day',
        ],
        'slider_speed' => [
            'allowed' => ':int:',
            'default' => 10,
        ],
        'stats_type' => [
            'allowed' => ':string:',
            'default' => 'donations_top',
        ],
        'text_template' => [
            'allowed' => ':string:',
            'default' => '{ sender } - { sum }',
        ],
        'title' => [
            'allowed' => ':any:',
            'default' => array(),
        ],
    ];
}
