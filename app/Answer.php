<?php

namespace App;

use App\Question;
use Illuminate\Database\Eloquent\Model;


class Answer extends Model
{
    protected $fillable=['answer_title','question_id','is_correct'];
    

    public function question(){
        return $this->belongsTo(Question::class);
    }
}
