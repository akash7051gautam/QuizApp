<?php

namespace App;

use App\User;
use App\Question;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = ['name','status','user_id'];

    protected $hidden = [
        'user_id'
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function question(){
        return $this->hasMany(Question::class);
    }
}
