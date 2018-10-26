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
        'is_whatsapp'       => FALSE,
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
        return '(' . $this->attributes['area_code'] . ') ' .
            substr($this->attributes['phone'], 0, -4) . '-' . substr($this->attributes['phone'], -4);
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
}
