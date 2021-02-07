<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use LaravelPropertyBag\Settings\HasSettings;

/**
 * @property int id
 */
class Widget extends Model
{
    use HasFactory, HasSettings;

    const TYPES = [
        '',
        'notifications',
        'goals',
        'media',
        'stats',
    ];

    protected $appends = [
        'embed_link',
        'settings',
    ];

    protected $guarded = [];

    /**
     * @var int
     */
    private int $user_id;

    /**
     * @var int
     */
    private int $widget_type_id;

    /**
     * @var String
     */
    private string $title;

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function getSettingsAttribute(): \Illuminate\Support\Collection
    {
        return $this->allSettings();
    }

    public function getEmbedLinkAttribute(): string
    {
        return URL::signedRoute('widget', ['type' => self::TYPES[$this->__get('widget_type_id')], 'id' => $this->__get('uuid')]);
    }
}
