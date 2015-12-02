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
class Submit extends AbstractElement
{
    private $button = false;

    public function __construct($name)
    {
        parent::__construct($name);

        $this->attributes['type'] = 'submit';
        $this->attributes['value'] = '';

        $this->rules['value'] = 'optional';
    }

    public function __toString()
    {
        if ($this->button) {
            $string = '<button';
            foreach ($this->attributes as $attribute => $value) {
                if ($attribute === 'value') continue;
                $string .= ' '.$attribute.'="'.$value.'"';
            }

            return $string.'>'.$this->attributes['value']."</button>\n";
        } else {
            $string = '<input';
            foreach ($this->attributes as $attribute => $value) {
                $string .= ' '.$attribute.'="'.$value.'"';
            }

            return $string.">\n";
        }
    }

    public function setValue($value)
    {
        $this->attributes['value'] = $value;

        return $this;
    }

    public function setButton($button)
    {
        $this->button = $button;

        return $this;
    }
}
