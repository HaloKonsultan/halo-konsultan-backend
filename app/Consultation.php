<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Consultation extends Pivot
{
    //
    protected $table = 'consultations';

    protected $fillable = [
        'description','consultant_id', 'user_id', 'title', 'consultation_price',
        'location', 'status','is_confirmed', 'preference', 'date', 
        'conference_link'
    ];

    public function consultant() {
        return $this->belongsTo('App\Consultant');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function transaction() {
        return $this->hasOne('App\Transaction', 'consultation_id');
    }

    public function preferenceDate() {
        return $this->hasMany('App\ConsultationPreferenceDate', 'consultation_id');
    }

    public function document() {
        return $this->hasMany('App\ConsultationDocument', 'consultation_id');
    }
}
