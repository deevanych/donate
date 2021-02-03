<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use LaravelPropertyBag\Settings\HasSettings;

/**
 * @property int id
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasSettings;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'avatar_url',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $with = [
        'donationVariations',
        'donationGoals',
        'socialNetworks',
    ];

    protected $appends = [
        'settings',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

//    Getters

    public function getReceivedDonations(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->receivedDonations()->get();
    }

    public function getSentDonations(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->sentDonations()->get();
    }

    public function getDonationVariations(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->donationVariations()->get();
    }

    public function getDonationGoals(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->donationGoals()->get();
    }

    public function getSettingsAttribute(): \Illuminate\Support\Collection
    {
        return $this->allSettings();
    }

    public function getSocialNetwork(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->socialNetworks()->get();
    }

    public function getWidgets(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->widgets()->get();
    }

//    Relations

    public function receivedDonations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Donation', 'user_to');
    }

    public function sentDonations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Donation', 'user_from');
    }

    public function donationVariations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\DonationVariation')->orderBy('sum');
    }

    public function widgets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Widget');
    }

    public function donationGoals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\DonationGoal');
    }

    public function socialNetworks(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany('App\Models\SocialNetwork')->withPivot('link');
    }

    public static function socialLogin($user, $type = 'twitch'): User
    {
        $user = User::firstOrCreate(
            [
                'email' => $user->email
            ],
            [
                'avatar_url' => $user->avatar,
                'name' => $user->nickname,
            ]
        );

        $socialNetwork = SocialNetwork::whereTitle($type)->first();
        $user->socialNetworks()->syncWithoutDetaching($socialNetwork->id);
        $user->socialNetworks()->updateExistingPivot($socialNetwork->id, [
            'link' => $socialNetwork->url.$user->name,
        ]);

        return $user;
    }
}
