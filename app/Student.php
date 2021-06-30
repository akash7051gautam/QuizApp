<?php

namespace App;

use App\ManagePassword;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $guard = 'api';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'roll_no',
        'email',
        'password',
        'status'
    ];

    public function managePassword(){
        return $this->hasOne(ManagePassword::class,'student_id');
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
