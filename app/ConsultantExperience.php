<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultantExperience extends Model
{
    //
    protected $table = 'consultant_experiences';
    
    protected $fillable = [
        'position', 'start_year', 'end_year'
    ];

    public function consultant() {
        return $this->belongsTo('App\Consultant');
    }
}
