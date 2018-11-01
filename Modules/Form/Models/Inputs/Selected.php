<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 01/11/2018
 * Time: 12:44
 */

namespace Modules\Form\Models\Inputs;


use Modules\Form\Models\Input;

class Selected extends Input
{
    const TYPE_INPUT = 'input-selected';

    /**
     * Selected constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $attributes = array_merge($this->getAttributes(), $attributes);
        if (!isset($attributes['type_input'])) $attributes['type_input'] = self::TYPE_INPUT;

        parent::__construct($attributes);
    }

    /**
     * @param string $key
     * @param string $par
     * @param array  $values
     * @return $this
     */
    public function options(string $key = '', string $par = '', array $values = [])
    {
        $this->attributes['options'] = [
            'key'    => $key,
            'par'    => $par,
            'values' => $values,
        ];

        return $this;
    }

    /**
     * @param array $array
     */
    public function values(array $array)
    {
        if (isset($this->attributes['options']['values'])) {
            $this->attributes['options']['values'] = $array;
        } else {
            $this->attributes['options'] = $array;
        }
    }
}
