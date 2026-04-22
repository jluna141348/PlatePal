<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $guarded = [];

    public function catererProfile()
    {
        return $this->belongsTo(CatererProfile::class, 'caterer_profile_id');
    }
}
