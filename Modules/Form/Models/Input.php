<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 01/11/2018
 * Time: 12:46
 */

namespace Modules\Form\Models;


use Jenssegers\Model\Model;

class Input extends Model
{
    const TYPE = 'text';
    const COL = 'col-12';
    const VALUE = '';
    /**
     * @var array
     */
    protected $fillable = [
        'label',
        'name',
        'col',
        'value',
        'validate',
        'type',
        'placeholder',
        'type_input',
    ];
    /**
     * @var array
     */
    protected $attributes = [
        'type'  => self::TYPE,
        'col'   => self::COL,
        'value' => self::VALUE,
    ];

    /**
     * @param $value
     */
    public function setNameAttribute($value)
    {
        if (!isset($this->attributes['label'])) $this->setLabelAttribute($value);
        $this->attributes['name'] = $value;
    }

    /**
     * @param $value
     */
    public function setLabelAttribute($value)
    {
        $this->attributes['label'] = __("form.$value");
    }

    /**
     * @param Input       $target
     * @param bool|string $condition
     * @param bool        $visible
     * @param bool        $cascade
     */
    public function condition($target, $condition, bool $visible = TRUE, bool $cascade = FALSE)
    {
        $this->attributes['condition'] = [
            'name'    => $target->name,
            'value'   => $condition,
            'default' => $visible,
            'cascade' => $cascade,
        ];
    }
}
