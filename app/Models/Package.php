<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'caterer_profile_id', 'name', 'description', 'price', 'price_note',
        'items', 'serving', 'min_guests', 'is_active',
    ];

    protected $casts = [
        'items' => 'array',
        'is_active' => 'boolean',
    ];

    public function catererProfile()
    {
        return $this->belongsTo(CatererProfile::class, 'caterer_profile_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
