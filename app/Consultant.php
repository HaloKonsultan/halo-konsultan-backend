<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Consultant extends Authenticatable implements JWTSubject
{
    use Notifiable;
    //
    protected $fillable = [
        'name', 'email', 'password', 'photo', 'gender', 'province', 'city',
        'likes_total', 'description', 'category_id', 'chat_price', 
        'consultation_price'
    ];

    protected $hidden = [
        'password', 'device_token'
    ];

    public function category() {
        return $this->belongsTo('App\Categories');
    }

    public function educations() {
        return $this->hasMany('App\ConsultantEducation');
    }

    public function skills() {
        return $this->hasMany('App\ConsultantSkill');
    }

    public function experience() {
        return $this->hasMany('App\ConsultantExperience');
    }

    public function virtualAccount() {
        return $this->hasMany('App\ConsultantVirtualAccount');
    }

    public function documentation() {
        return $this->hasMany('App\ConsultantDocumentation');
    }

    public function forum() {
        return $this->hasMany('App\Forum');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
