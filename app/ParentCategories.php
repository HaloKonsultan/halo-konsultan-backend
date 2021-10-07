<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParentCategories extends Model
{
    //
    protected $table = 'parent_categories';
    
    protected $fillable = [
        'name'
    ];

    public function category() {
        return $this->hasMany('App\Categories', 'parent_id', 'id');
    }
}
