<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBankDocument extends Model
{
    //
    protected $table = 'user_bank_documents';

    protected $fillable = [
        'user_id', 'filename', 'url'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
