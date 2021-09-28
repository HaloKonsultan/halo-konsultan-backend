<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    //
    protected $table = 'consultations';

    protected $fillable = [
        'description', 'title', 'consultation_price', 'location', 'status',
        'is_confirmed', 'preference', 'date', 'conference_link'
    ];

    public function consultant() {
        return $this->belongsTo('App\Consultant');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function transaction() {
        return $this->hasMany('App\Transaction');
    }

    public function preferenceDate() {
        return $this->hasMany('App\ConsultationPreferenceDate');
    }

    public function document() {
        return $this->hasMany('App\ConsultationDocument');
    }
}
