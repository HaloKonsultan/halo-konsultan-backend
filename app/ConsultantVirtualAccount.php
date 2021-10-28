<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultantVirtualAccount extends Model
{
    //
    protected $table = 'consultant_virtual_accounts';
    
    protected $fillable = [
        'consultant_id', 'card_number', 'bank', 'name'
    ];

    public function consultant() {
        return $this->belongsTo('App\Consultant');
    }
}
