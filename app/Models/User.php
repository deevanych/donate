<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
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

    protected $with = [
        'donationVariations',
        'donationGoals',
    ];

    protected $appends = [
        'settings',
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

    public function donationGoals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\DonationGoal');
    }

    public static function socialLogin($user, $type = 'twitch'): User
    {
        return User::firstOrCreate(
            [
                'email' => $user->email
            ],
            [
                'avatar_url' => $user->avatar,
                'name' => $user->nickname,
            ]
        );
    }
}
