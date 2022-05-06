<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'requester', 'responder', 'status', 'requester_comment', 'responder_comment', 'services_ids', 'date'
    ];

    public function getDateAttribute($value)
    {
        $date = Carbon::parse($value);
        return ['persian' => $date->toJalali()->format('Y/n/j H:i'), 'original' => $value];
    }

    public function getStatusAttribute($value)
    {
        if ($value === '1') {
            $status = 'در انتظار تایید';
        } elseif ($value === '2') {
            $status = 'تایید شده';
        }elseif ($value === '3') {
            $status = 'رد شده';
        } else {
            $status = 'لغو شده';
        }

        return $status;
    }

    public function getServicesIdsAttribute($value)
    {
        return json_decode($value);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester');
    }

    public function responder()
    {
        return $this->belongsTo(Provider::class, 'responder');
    }

}
