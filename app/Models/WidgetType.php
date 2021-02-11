<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class WidgetType extends Model
{
    use HasFactory;

    const MEDIA_TYPE = 'media';

    public function widgets(): HasMany
    {
        return $this->hasMany('App\Models\Widget')->where('user_id', '=', Auth::id());
    }
}
