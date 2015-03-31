<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mendo\Form\Element;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
use Mendo\Form\AbstractComponent;
use Mendo\Form\FieldSet;
use Mendo\Filter\FilterableInterface;

abstract class AbstractElement extends AbstractComponent implements FilterableInterface
{
    protected $label;
    protected $fieldSet;
    protected $listeners = [];
    protected $rules = [];
    protected $errors = [];

    public function __construct($name)
    {
        parent::__construct($name);

        $this->attributes['name'] = $name;
        $this->rules['value'] = 'required';
    }

    public function setData($data)
    {
        $this->setValue($data);

        if ($this->fieldSet) {
            $this->fieldSet->updateEntity($this);
        }

        return $this;
    }

    public function setFieldSet(FieldSet $fieldSet)
    {
        $this->fieldSet = $fieldSet;
    }

    public function setValue($value)
    {
        $this->attributes['value'] = $value;

        return $this;
    }

    public function getValue()
    {
        return $this->attributes['value'];
    }

    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getRules()
    {
        return $this->rules;
    }

    public function setFilters($filters)
    {
        $this->rules['value'] = $filters;

        return $this;
    }

    public function hasErrors()
    {
        return (bool) $this->errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }
}
