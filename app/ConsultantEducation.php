<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultantEducation extends Model
{
    //
    protected $table = 'consultant_educations';

    protected $fillable = [
        'consultant_id', 'institution_name', 'major', 'start_year', 'end_year'
    ];

    public function consultant() {
        return $this->belongsTo('App\Consultant');
    }
}
