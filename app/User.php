<?php

namespace App;

use App\Quiz;
use App\Question;
use App\Notifications\UserRegistered;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\Notification;
use Spatie\Activitylog\Traits\CausesActivity;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles, LogsActivity, CausesActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     * 
     */

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


    public function blogs()
    {
        return $this->hasMany(Blog::class, 'author_id');
    }

    public function quiz()
    {
        return $this->hasMany(Quiz::class, 'author_id');
    }

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function question(){
        return $this->hasMany(Question::class,'user_id');
    }
}
