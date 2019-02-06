<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, SoftDeletes, HasApiTokens;

    /**
     * @var string
     */
    protected $keyType = 'uuid';
    /**
     * @var bool
     */
    public $incrementing = FALSE;
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'social_name',
        'nickname',
        'email',
        'password',
        'gender',
        'birth_date',
        'avatar',
        'referer',
        'document',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = ['birth_date'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function address()
    {
        return $this->hasOne(Address::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function phone()
    {
        return $this->hasOne(Phone::class);
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
    public function setBirthDateAttribute($value)
    {
        if (filled($value) && is_string($value)) {
            $this->attributes['birth_date'] = Carbon::createFromFormat('Y-m-d', $value);
        } else {
            $this->attributes['birth_date'] = $value;
        }
    }

    /**
     * @return string
     */
    public function getShortNameAttribute()
    {
        if (NULL !== $this->attributes['nickname']) return explode(' ', $this->attributes['nickname'])[0];

        return explode(' ', $this->attributes['name'])[0];
    }

    /**
     * @return string
     */
    public function getAvatarAttribute()
    {
        return \Storage::url($this->attributes['avatar']);
    }

    /**
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'user_id';
    }

    /**
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($this->attributes, $token));
    }

    /**
     *
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification($this->attributes));
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string)Str::uuid();
            $model->user_id = (string)Str::uuid();
            $model->username = kebab_case($model->name);
        });
    }
}
