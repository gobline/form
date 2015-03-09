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
class Password extends AbstractElement
{
    public function __construct($name)
    {
        parent::__construct($name);

        $this->attributes['type'] = 'password';
        $this->attributes['value'] = '';

        $this->rules['value'] = 'required';
    }

    public function __toString()
    {
        $string = '<input';
        foreach ($this->attributes as $attribute => $value) {
            if ($attribute === 'value') {
                continue;
            }

            $string .= ' '.$attribute.'="'.$value.'"';
        }

        return $string.">\n";
    }
}
