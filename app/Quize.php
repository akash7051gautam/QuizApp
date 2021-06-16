<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quize extends Model
{
    protected $table = 'quizes';
    protected $fillable = ['name','status'];
}
