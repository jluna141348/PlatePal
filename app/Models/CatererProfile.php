<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatererProfile extends Model
{
    protected $fillable = [
        'user_id', 'business_name', 'slug', 'description', 'cover_photo',
        'phone', 'email', 'barangay', 'cuisine_type', 'price_min',
        'price_max', 'min_guests', 'max_guests', 'is_featured',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function gallery()
    {
        return $this->hasMany(Gallery::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_caterers');
    }
}
