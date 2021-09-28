<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    //
    protected $table = 'categories';

    protected $fillable = [
        'name', 'logo'
    ];

    public function consultant() {
        return $this->hasMany('App\Consultant');
    }

    public function parent() {
        return $this->belongsTo('App\ParentCategories');
    }
}
