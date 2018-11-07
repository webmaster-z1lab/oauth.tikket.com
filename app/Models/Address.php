<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes, UuidTrait;
    /**
     * @var bool
     */
    public $incrementing = FALSE;
    /**
     * @var string
     */
    protected $keyType = 'uuid';
    /**
     * @var array
     */
    protected $fillable = [
        'street',
        'number',
        'complement',
        'district',
        'city',
        'state',
        'postal_code',
        'ibge_id'
    ];
    /**
     * @var array
     */
    protected $attributes = ['complement' => NULL];
    /**
     * @var array
     */
    protected $casts = ['number' => 'integer', 'ibge_id' => 'integer'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedAttribute()
    {
        $postal = substr_replace($this->attributes['postal_code'], '-', 5, 0);

        return "{$this->attributes['street']}, {$this->attributes['number']} - {$this->attributes['district']}, {$this->attributes['complement']} "
            . PHP_EOL .
            "{$this->attributes['city']}, {$this->attributes['state']} - {$postal}";
    }
}
