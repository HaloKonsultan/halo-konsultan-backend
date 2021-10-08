<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultationPreferenceDate extends Model
{
    //
    protected $table = 'consultation_preference_date';

    protected $fillable = [
        'consultation_id', 'date'
    ];

    public function consultation() {
        return $this->belongsTo('App\Consultation');
    }
}
