<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use Creativeorange\Gravatar\Facades\Gravatar;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\Auth\ResetPassword as ResetPasswordNotification;
use App\Notifications\Auth\Verification as EmailVerificationNotification;

class User extends Authenticatable implements Auditable, MustVerifyEmail
{
    use HasRoles, Notifiable, \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'first_name', 'last_name', 'email', 'email_verified_at', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the welcome token for new users.
     */
    public function welcomeToken()
    {
        return $this->hasOne(WelcomeToken::class);
    }

    /**
     * Send the email verification notification.
     *
     * @param string $token
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new EmailVerificationNotification());
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($this, $token));
    }

    /**
     * Get the user's gravatar.
     *
     * @return string
     */
    public function getGravatarAttribute()
    {
        if (app()->environment('local')) {
            return asset('img/gravatar/default.png');
        }

        return Gravatar::get($this->email);
    }

    /**
     * Get the user's user roles.
     *
     * @return string
     */
    public function getRoleAttribute()
    {
        return implode(', ', $this->roles()->pluck('display_name')->toArray());
    }
}
