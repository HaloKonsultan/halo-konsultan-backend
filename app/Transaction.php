<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $table = 'transactions';

    protected $fillable = [
        'consultation_id', 'external_id', 'status_invoice',
        'status_disbursment', 'amount', 'invoice_url', 'expiry_date',
        'bank_code', 'account_holder_name', 'account_number'
    ];

    public function consultation() {
        return $this->belongsTo('App\Consultation');
    }
}
