<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['roll_no', 'email', 'first_name', 'last_name','password','user_id','status'];

    protected $hidden = [
        'password',
    ];

}
