<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repositories extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
