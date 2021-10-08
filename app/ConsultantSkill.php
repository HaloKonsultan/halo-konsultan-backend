<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultantSkill extends Model
{
    //
    protected $table = 'consultant_skills';

    protected $fillable = [
        'consultant_id' ,'skills'
    ];

    public function consultant() {
        return $this->belongsTo('App\Consultant');
    }
}
