<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $table = 'transactions';

    protected $fillable = [
        'status'
    ];

    public function consultation() {
        return $this->belongsTo('App\Consultation');
    }
}
