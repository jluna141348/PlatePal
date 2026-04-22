<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'client_id', 'caterer_profile_id', 'package_id', 'event_name',
        'event_date', 'event_time', 'guest_count', 'venue',
        'notes', 'total_amount', 'status',
    ];

    protected $casts = [
        'event_date' => 'date',
        'event_time' => 'datetime:H:i:s',
        'total_amount' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function catererProfile()
    {
        return $this->belongsTo(CatererProfile::class, 'caterer_profile_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
