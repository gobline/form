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
class RadioGroup extends AbstractElement
{
    private $options = [];
    private $radioElements = [];
    private $checkedValue;

    public function __construct($name)
    {
        parent::__construct($name);
    }

    public function setOptions(array $options)
    {
        $this->options = $options;

        foreach ($options as $value => $label) {
            $radio = new Radio($this->attributes['name']);
            $radio->setLabel($label);
            $radio->setValue($value);

            $this->radioElements[$value] = $radio;
        }

        return $this;
    }

    public function setValue($value)
    {
        $this->checkedValue = $value;

        $this->radioElements[$value]->setChecked(true);

        return $this;
    }

    public function getValue()
    {
        return $this->checkedValue;
    }

    public function getSwitches()
    {
        return $this->radioElements;
    }

    public function setAttribute($name, $value)
    {
        parent::setAttribute($name, $value);

        if ($name !== 'id') {
            foreach ($this->radioElements as $element) {
                $element->setAttribute($name, $value);
            }
        }

        return $this;
    }
}
