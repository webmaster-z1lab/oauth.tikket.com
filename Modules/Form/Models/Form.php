<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 01/11/2018
 * Time: 10:45
 */

namespace Modules\Form\Models;

use Jenssegers\Model\MassAssignmentException;
use Jenssegers\Model\Model;


class Form extends Model
{
    const METHOD = 'POST';
    const FIELDSET = FALSE;
    const FORM = [];
    /**
     * @var array
     */
    protected $fillable = [
        'self',
        'action',
        'return',
        'callback',
    ];
    /**
     * @var array
     */
    protected $attributes = [
        'method'    => self::METHOD,
        'form'      => self::FORM,
        'field_set' => self::FIELDSET,
    ];

    /**
     * @param $value
     */
    public function setActionAttribute($value)
    {
        if (str_contains($value, 'update')) $this->attributes['method'] = 'PUT';

        $this->attributes['action'] = $value;
    }

    /**
     * @param $field
     * @return $this
     */
    public function add($field)
    {
        if ($field instanceof Fieldset) {
            $this->fieldset($field);
        } else {
            $this->input($field);
        }

        return $this;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function createMany(array $fields)
    {
        foreach ($fields as $field) {
            if($field instanceof Fieldset) throw new MassAssignmentException('createMany accepts only Inputs');

            $this->add($field);
        }

        return $this;
    }

    /**
     * @param Fieldset $fieldset
     */
    private function fieldset(Fieldset $fieldset)
    {
        $this->attributes['field_set'] = TRUE;

        $this->setFormAttribute($fieldset->toArray());
    }

    /**
     * @param \Modules\Form\Models\Input $input
     */
    private function input($input)
    {
        if ($this->attributes['field_set']) throw new MassAssignmentException('Not allowed to set input and fieldsets in same Model');

        $this->setFormAttribute($input->toArray());
    }

    /**
     * @return mixed
     */
    public function getFormAttribute()
    {
        return $this->attributes['form'];
    }

    /**
     * @param array $data
     */
    public function setFormAttribute(array $data = [])
    {
        $this->attributes['form'][] = $data;
    }
}
