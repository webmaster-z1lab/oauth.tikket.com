<?php

namespace App\Models;

use App\Traits\MustVerifyPhone;
use Jenssegers\Mongodb\Eloquent\Model;

class Phone extends Model
{
    use MustVerifyPhone;

    protected $fillable = ['area_code', 'phone', 'is_whatsapp'];

    protected $attributes = ['phone_verified_at' => null, 'is_whatsapp' => false];

    protected $casts = ['is_whatsapp' => 'boolean'];

    /**
     * @return string
     */
    public function getFormattedPhoneAttribute()
    {
        return '(' . $this->attributes['area_code'] . ') ' .
            substr($this->attributes['phone'], 0, -4) . '-' . substr($this->attributes['phone'], -4);
    }

    /**
     * @param $value
     */
    public function setIsWhatsappAttribute($value)
    {
        if ($value === 'false') {
            $this->attributes['is_whatsapp'] = false;
        } else {
            $this->attributes['is_whatsapp'] = (bool) $value;
        }
    }
}