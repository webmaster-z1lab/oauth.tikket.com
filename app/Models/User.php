<?php

namespace App\Models;

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

    protected $keyType = 'uuid';

    public $incrementing = false;

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

    protected $dates = ['birthdate'];

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
    public function setBirthdateAttribute($value)
    {
        if (filled($value) && is_string($value)) {
            $this->attributes['birthdate'] = Carbon::createFromFormat('d/m/Y', $value);
        } else {
            $this->attributes['birthdate'] = $value;
        }
    }

    /**
     * @return false|null|string
     */
    public function getFormattedAddressAttribute()
    {
        if (!$this->address()->exists()) {
            return null;
        }
        $address = array_only($this->address->toArray(), ['street', 'number', 'complement', 'district', 'city', 'state', 'postal_code']);

        return json_encode($address);
    }

    /**
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'user_id';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
            $model->user_id = (string) Str::uuid();
            $model->username = kebab_case($model->name);
        });
    }
}
