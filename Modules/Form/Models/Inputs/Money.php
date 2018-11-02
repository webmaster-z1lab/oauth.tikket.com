<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 01/11/2018
 * Time: 12:44
 */

namespace Modules\Form\Models\Inputs;


use Modules\Form\Models\Input;

class Money extends Input
{
    const TYPE_INPUT = 'input-money';

    public function __construct(array $attributes = [])
    {
        $attributes = array_merge($this->getAttributes(), $attributes);
        $attributes['type_input'] = self::TYPE_INPUT;

        parent::__construct($attributes);
    }

    public function percentage()
    {
        $this->attributes['percentage'] = TRUE;
    }
}