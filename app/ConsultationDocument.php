<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultationDocument extends Model
{
    //
    protected $table = 'consultation_documents';

    protected $fillable = [
        'consultation_id', 'name', 'description', 'file'
    ];

    public function consultaton() {
        return $this->belongsTo('App\Consultation');
    }
}
