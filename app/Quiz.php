<?php

namespace App;

use App\User;
use App\Answer;
use App\Question;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = ['name', 'status', 'user_id'];

    protected $hidden = [
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function question(){
    //     return $this->hasMany(Question::class,'quiz_id');
    // }

    // public function answer(){
    //     return $this->hasMany(Answer::class);
    // }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }

    // public function banner(){
    //     return $this->belongsTo(Banner::class);
    // }
}
