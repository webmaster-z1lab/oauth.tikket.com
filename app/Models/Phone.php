<?php

namespace App\Models;

use App\Traits\MustVerifyPhone;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Phone extends Model
{
    use UuidTrait, MustVerifyPhone, SoftDeletes;

    public $incrementing = FALSE;

    protected $keyType = 'uuid';

    protected $fillable = [
        'is_whatsapp',
        'area_code',
        'phone',
    ];

    protected $attributes = [
        'phone_verified_at' => NULL,
        'is_whatsapp' => FALSE,
    ];

    protected $casts = [
        'is_whatsapp' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return string
     */
    public function getFormattedPhoneAttribute()
    {
        $start = strlen($this->attributes['phone']) === 8 ? 4 : 5;

        return "({$this->attributes['area_code']}) " . substr_replace($this->attributes['phone'], '-', $start, 0);
    }

    public function getPhoneNumberAttribute()
    {
        return $this->attributes['area_code'] . $this->attributes['phone'];
    }

    /**
     * @param $value
     */
    public function setIsWhatsappAttribute($value)
    {
        if ($value === 'false') {
            $this->attributes['is_whatsapp'] = FALSE;
        } else {
            $this->attributes['is_whatsapp'] = (bool)$value;
        }
    }

    /**
     * @param $value
     */
    public function setPhoneAttribute($value)
    {
        $this->attributes['area_code'] = substr($value, 0, 2);
        $this->attributes['phone'] = substr($value, 2);
    }
}
