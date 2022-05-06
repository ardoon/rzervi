<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $fillable = [
        'name',
        'path',
        'type',
        'user_id'
    ];

    use HasFactory;

    public function getPathAttribute($value)
    {
        return url('/') . Storage::disk()->url($value);
    }
}
