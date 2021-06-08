<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Notifications\UserRegistered;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Notification;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use Notifiable, HasRoles, LogsActivity, CausesActivity;

    protected $guard = 'admin';
    
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected static $logAttributes = ['name', 'email','password'];
    protected static $logOnlyDirty = true;

    protected static $logAttributesToIgnore = ['remember_token'];
    protected static $ignoreChangedAttributes = ['remember_token'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
