<?php

namespace App;

use App\Student;
use Illuminate\Database\Eloquent\Model;

class ManagePassword extends Model
{
    protected $fillable = ['password','student_id','org_id'];

    public function student(){
        return $this->belongsTo(App\Student::class,'id');
    }

    public function Organization(){
        return $this->hasOne(App\User::class);
    }
}
