<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Quiz extends Model
{
    protected $fillable = ['name','status','user_id'];

    protected $hidden = [
        'user_id'
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
