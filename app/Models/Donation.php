<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property float sum
 * @property string text
 * @property number user_from
 * @property number user_to
 * @property string media
 * @property string speech_uri
 * @property string donation_sender
 * @property integer id
 */
class Donation extends Model
{
    use HasFactory;

    protected $guarded = [];
    /**
     * @var mixed
     */
    private $user;

    /**
     * @var mixed|string
     */

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_to');
    }

    public function getSender()
    {
        return $this->belongsTo('App\Models\User', 'user_from')->get();
    }

    public function getReceiver()
    {
        return $this->belongsTo('App\Models\User', 'user_to')->get();
    }

    public function getSum()
    {
        return $this->sum;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getMedia()
    {
        return $this->media;
    }
}
