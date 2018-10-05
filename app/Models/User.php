<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail as VerifiableEmail;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements VerifiableEmail
{
    use Notifiable, MustVerifyEmail, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'social_name', 'nickname', 'email', 'password', 'gender', 'birthdate'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $attributes = ['phone_verified_at' => null];

    protected $dates = ['birthdate'];

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function roles()
    {
        return $this->embedsMany(Role::class);
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsOne
     */
    public function address()
    {
        return $this->embedsOne(Address::class);
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsOne
     */
    public function phone()
    {
        return $this->embedsOne(Phone::class);
    }

    /**
     * @param string $value
     */
    public function setPasswordAttribute(string $value)
    {
        $this->attributes['password'] = \Hash::make($value);
    }

    /**
     * @param $value
     */
    public function setBirthdateAttribute($value)
    {
        if (filled($value) && is_string($value)) {
            $this->attributes['birthdate'] = Carbon::createFromFormat('d/m/Y', $value);
        }
    }

    /**
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'user_id';
    }
}
