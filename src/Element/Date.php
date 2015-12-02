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
class Date extends AbstractElement
{
    public function __construct($name)
    {
        parent::__construct($name);

        $this->attributes['type'] = 'date';
        $this->attributes['value'] = '';
    }

    public function __toString()
    {
        $string = '<input';
        foreach ($this->attributes as $attribute => $value) {
            $string .= ' '.$attribute.'="'.$value.'"';
        }

        return $string.">\n";
    }

    public function setValue($value)
    {
        if (is_string($value)) {
            $value = new \DateTime($value);
        }

        $this->attributes['value'] = $value->format('Y-m-d');

        return $this;
    }

    public function getValue()
    {
        $value = $this->attributes['value'];
        if (is_string($value)) {
            $value = new \DateTime($value);
        }

        return $value;
    }
}
