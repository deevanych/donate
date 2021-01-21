<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @property int id
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $with = [
        'donationVariations',
        'donationGoals',
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

    public function getReceivedDonations() {
        return $this->receivedDonations()->get();
    }

    public function getSentDonations() {
        return $this->sentDonations()->get();
    }

    public function getDonationVariations() {
        return $this->donationVariations()->get();
    }

    public function getDonationGoals() {
        return $this->donationGoals()->get();
    }

//    Relations

    public function receivedDonations() {
        return $this->hasMany('App\Models\Donation', 'user_to');
    }

    public function sentDonations() {
        return $this->hasMany('App\Models\Donation', 'user_from');
    }

    public function donationVariations() {
        return $this->hasMany('App\Models\DonationVariation')->orderBy('sum');
    }

    public function donationGoals() {
        return $this->hasMany('App\Models\DonationGoal');
    }
}
