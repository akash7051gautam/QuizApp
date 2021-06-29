<?php

namespace App;

use App\ManagePassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable;

    protected $guard = 'student';

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
}
