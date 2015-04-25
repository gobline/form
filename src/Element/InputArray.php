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
class InputArray extends AbstractElement
{
    private $i = -1;

    public function __construct($name, $type = 'text')
    {
        parent::__construct($name);

        $this->attributes['type'] = $type;
        $this->attributes['value'] = [];

        $this->rules['value[]'] = 'required|trim';
    }

    public function __toString()
    {
        ++$this->i;
        $string = '<input';
        foreach ($this->attributes as $attribute => $value) {
            if ($attribute === 'name') {
                $value .= '[]';
            } elseif ($attribute === 'id') {
                $value .= '-'.$this->i;
            } elseif ($attribute === 'value') {
                if (isset($value[$this->i])) {
                    $value = $value[$this->i];
                } else {
                    continue;
                }
            }

            $string .= ' '.$attribute.'="'.$value.'"';
        }

        return $string.">\n";
    }

    public function addErrors(array $errors)
    {
        $this->errors = $errors;
    }

    public function hasErrors()
    {
        if (!isset($this->errors[$this->i])) {
            return false;
        }
        return (bool) $this->errors[$this->i];
    }

    public function getErrors()
    {
        if (!isset($this->errors[$this->i])) {
            return [];
        }

        return $this->errors[$this->i];
    }
}
