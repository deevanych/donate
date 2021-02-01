<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

/**
 * @property int id
 */
class Widget extends Model
{
    use HasFactory, Uuids;

    protected $appends = [
        'embed_link',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function getEmbedLinkAttribute(): string
    {
        return URL::signedRoute('widget', ['type' => 'media', 'id' => $this->id]);
    }
}
