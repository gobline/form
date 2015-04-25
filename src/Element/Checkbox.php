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
class Checkbox extends AbstractElement
{
    private $checked = false;

    public function __construct($name)
    {
        parent::__construct($name);

        $this->attributes['type'] = 'checkbox';
        $this->attributes['value'] = '1';

        $this->rules['value'] = 'optional';
    }

    public function __toString()
    {
        $string = '<input name="'.$this->attributes['name']."\" type=\"hidden\" value=\"0\">\n<input";
        foreach ($this->attributes as $attribute => $value) {
            $string .= ' '.$attribute.'="'.$value.'"';
        }

        if ($this->checked) {
            $string .= ' checked';
        }

        return $string.">\n";
    }

    public function setChecked($checked)
    {
        $this->checked = $checked;
    }

    public function setValue($value)
    {
        if (!isset($this->attributes['value'])) {
            $this->attributes['value'] = $value;
        } elseif ($value === $this->attributes['value']) {
            $this->setChecked(true);
        }
    }

    public function getValue()
    {
        if ($this->checked) {
            return $this->attributes['value'];
        } else {
            return false;
        }
    }
}
