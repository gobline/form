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
class Radio extends AbstractElement
{
    private $options = [];
    private $checked = false;

    public function __construct($name)
    {
        parent::__construct($name);

        $this->attributes['type'] = 'radio';
    }

    public function __toString()
    {
        $string = '<input';
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
}
