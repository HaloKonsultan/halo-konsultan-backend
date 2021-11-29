<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    //
    protected $table = 'forums';

    protected $fillable = [
        'consultant_id', 'user_id', 'is_ended'
    ];

    public function message() {
        return $this->hasMany('App\Message');
    }

    public function consultant() {
        return $this->belongsTo('App\Consultant');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
