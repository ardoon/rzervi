<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'type',
        'gender',
        'phone_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $with = ['avatar'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasVerifiedPhone()
    {
        return $this->attributes['phone_verified_at'];
    }

    public function markPhoneAsVerified()
    {
        $this->attributes['phone_verified_at'] = Carbon::now();
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function servers()
    {
        return $this->belongsToMany(Provider::class, 'customer_provider', 'user_id', 'provider_id');
    }

    public function requests()
    {
        return $this->hasMany(Request::class, 'requester')->with('responder');
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function avatar()
    {
        return $this->media()->where('type', '=', 'avatar');
    }

}
