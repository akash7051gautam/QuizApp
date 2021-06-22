<?php

namespace App;

use App\Question;
use Illuminate\Database\Eloquent\Model;


class Answer extends Model
{
    protected $fillable=['answer_title','question_id','is_correct'];
    
    protected $appends = ['option'];

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function getOptionAttribute(){
        return $this->answer_title;
    }
}
