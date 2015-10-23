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
class Select extends AbstractElement
{
    private $options = [];
    private $selectedValue;

    public function __construct($name)
    {
        parent::__construct($name);
    }

    public function __toString()
    {
        $string = '<select';
        foreach ($this->attributes as $attribute => $value) {
            $string .= ' '.$attribute.'="'.$value.'"';
        }
        $string .= ">\n";

        foreach ($this->options as $value => $label) {
            $value = (string) $value;
            $string .= '<option value="'.$value.'"'.($this->selectedValue === $value ? ' selected' : '').'>'.$label."</option>\n";
        }

        return $string."<select>\n";
    }

    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    public function setValue($value)
    {
        $this->selectedValue = (string) $value;

        return $this;
    }

    public function getValue()
    {
        return $this->selectedValue;
    }
}
