<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmail;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
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
            $this->attributes['birth_date'] = Carbon::createFromFormat('d/m/Y', $value);
        } else {
            $this->attributes['birth_date'] = $value;
        }
    }

    /**
     * @return false|null|string
     */
    public function getFormattedAddressAttribute()
    {
        if (!$this->address()->exists()) return NULL;

        $address = array_only($this->address->toArray(), ['street', 'number', 'complement', 'district', 'city', 'state', 'postal_code']);

        return json_encode($address);
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
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getAttribute($this->getAuthIdentifierName());
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
        $this->notify(new VerifyEmail($this->attributes));
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
