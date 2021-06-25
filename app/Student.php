<?php

namespace App;

use App\ManagePassword;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
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
