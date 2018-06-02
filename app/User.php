<?php

namespace App;

use App\Notifications\SetPassword;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //Get employee record of the user
    public function Employee_Record(){
        return $this->hasOne("App\Employee");
    }

    // Notification  recipient
    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }

    public function sendPasswordResetNotification($token)
    {
        if($this->activation_link_sent){
            $this->notify(new ResetPassword($token));
        }
        else $this->notify(new SetPassword($token));

    }
}
