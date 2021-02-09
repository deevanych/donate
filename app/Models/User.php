<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
            'link' => $socialNetwork->url . $user->name,
        ]);

        return $user;
    }

    public function getReceivedDonations(): Collection
    {
        return $this->receivedDonations()->get();
    }

    public function receivedDonations(): HasMany
    {
        return $this->hasMany('App\Models\Donation', 'user_to');
    }

    public function getSentDonations(): Collection
    {
        return $this->sentDonations()->get();
    }

    public function sentDonations(): HasMany
    {
        return $this->hasMany('App\Models\Donation', 'user_from');
    }

    public function getDonationVariations(): Collection
    {
        return $this->donationVariations()->get();
    }

    public function donationVariations(): HasMany
    {
        return $this->hasMany('App\Models\DonationVariation')->orderBy('sum');
    }

    public function getWidgets(): Collection
    {
        return $this->widgets()->get();
    }

//    Relations

    public function getDonationGoals(): Collection
    {
        return $this->donationGoals()->get();
    }

    public function donationGoals(): HasMany
    {
        return $this->hasMany('App\Models\DonationGoal');
    }

    public function getSettingsAttribute(): \Illuminate\Support\Collection
    {
        return $this->allSettings();
    }

    public function getSocialNetwork(): Collection
    {
        return $this->socialNetworks()->get();
    }

    public function socialNetworks(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\SocialNetwork')->withPivot('link');
    }

    public function widgets(): HasMany
    {
        return $this->hasMany('App\Models\Widget');
    }
}
