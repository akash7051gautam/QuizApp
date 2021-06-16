<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //

    protected $fillable = ['id','question','type','point','option_id','is_correct','user_id'];

    public function option(){
        return $this->hasMany(Option::class);
    }

    public function user(){
        return $this->belongsTo(User::class,'id');
    }
}
