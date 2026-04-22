<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'caterer_profile_id', 'rating', 'comment', 'event_type'];

    public function catererProfile()
    {
        return $this->belongsTo(CatererProfile::class, 'caterer_profile_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
