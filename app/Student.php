<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable=['user_id','first_name','last_name','roll_no','email','password','status'];
}
