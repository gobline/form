<?php

/*
 * Gobline Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gobline\Form\Element;

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

        return $this;
    }

    public function setValue($value)
    {
        if (is_bool($value)) {
            $value = ($value) ? '1' : '0';
        }

        if ($value === $this->attributes['value']) {
            $this->setChecked(true);
        } else {
            $this->setChecked(false);
        }

        return $this;
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
