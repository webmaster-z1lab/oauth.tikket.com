<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 01/11/2018
 * Time: 11:11
 */

namespace Modules\Form\Models;


use Jenssegers\Model\MassAssignmentException;
use Jenssegers\Model\Model;

class Fieldset extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'legend',
        'subtitle',
    ];
    /**
     * @var array
     */
    protected $attributes = [
        'inputs' => [],
    ];

    /**
     * @param Input $input
     * @return $this
     */
    public function create($input)
    {
        $this->setInputsAttribute($input->toArray());

        return $this;
    }

    /**
     * @param array $data
     */
    public function setInputsAttribute(array $data = [])
    {
        $this->attributes['inputs'][] = $data;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function createMany(array $fields)
    {
        foreach ($fields as $field) {
            if ($field instanceof Fieldset) throw new MassAssignmentException('createMany accepts only Inputs');

            $this->create($field);
        }

        return $this;
    }
}
