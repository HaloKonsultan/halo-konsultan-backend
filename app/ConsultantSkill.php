<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultantSkill extends Model
{
    //
    protected $table = 'consultant_skills';

    protected $fillable = [
        'skills'
    ];

    public function consultant() {
        return $this->belongsTo('App\Consultant');
    }
}
