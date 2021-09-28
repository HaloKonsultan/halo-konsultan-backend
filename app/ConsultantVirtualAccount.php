<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultantVirtualAccount extends Model
{
    //
    protected $table = 'consultant_virtual_accounts';
    
    protected $fillable = [
        'card_number', 'bank'
    ];

    public function consultant() {
        return $this->belongsTo('App\Consultant');
    }
}
