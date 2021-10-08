<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultantDocumentation extends Model
{
    //
    protected $table = 'consultant_documentations';

    protected $fillable = [
        'consultant_id','photo'
    ];

    public function consultant() {
        return $this->belongsTo('App\Consultant');
    }
}
