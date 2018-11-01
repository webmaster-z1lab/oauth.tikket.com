<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 01/11/2018
 * Time: 12:42
 */

namespace Modules\Form\Models\Inputs;


use Modules\Form\Models\Input;

class Date extends Input
{
    const TYPE_INPUT = 'input-date';
    const FORMAT = 'D-M-Y';

    public function __construct(array $attributes = [])
    {
        $attributes = array_merge($this->getAttributes(), $attributes);
        $attributes['type_input'] = self::TYPE_INPUT;
        $attributes['format'] = self::FORMAT;

        parent::__construct($attributes);
    }
}
