<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'type',
        'lat',
        'lng',
        'address',
    ];

    protected $with = ['avatar'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function customers()
    {
        return $this->belongsToMany(User::class, 'customer_provider', 'provider_id', 'user_id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class)->withPivot('price', 'description');
    }

    public function requests()
    {
        return $this->hasMany(Request::class, 'responder')->with('requester');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'user_id');
    }

    public function avatar()
    {
        return $this->media()->where('type', '=', 'provider');
    }

}
