<?php

namespace App\Settings;

use LaravelPropertyBag\Settings\ResourceConfig;

class UserSettings extends ResourceConfig
{
    /**
     * Registered settings for the user. Register settings by setting name. Each
     * setting must have an associative array set as its value that contains an
     * array of 'allowed' values and a single 'default' value.
     *
     * @var array
     */
    protected $registeredSettings = [
        'main_color' => [
            'allowed' => ':any:',
            'default' => '#007bff',
        ],
        'donate_button_text' => [
            'allowed' => ':any:',
            'default' => 'Отправить',
        ],
        'background_uri' => [
            'allowed' => ':any:',
            'default' => 'https://static.donationalerts.ru/uploads/images/3107503/1588490770_39-p-prostie-rozovie-foni-89.jpg',
        ],
        'enabled_media' => [
            'allowed' => ':bool:',
            'default' => true,
        ],
        'enabled_donation_variations' => [
            'allowed' => ':bool:',
            'default' => true,
        ],
        'enabled_donation_goals' => [
            'allowed' => ':bool:',
            'default' => true,
        ],
        'donation_min_sum' => [
            'allowed' => ':int:',
            'default' => 100,
        ],
        'donation_media_min_sum' => [
            'allowed' => ':int:',
            'default' => 150,
        ],
    ];
}
