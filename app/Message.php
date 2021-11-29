<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $table = 'messages';

    protected $fillable = [
        'forum_id', 'message', 'sender', 'is_read'
    ];

    public function forum() {
        return $this->belongsTo('App\Forum');
    }
}
