<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mendo\Form;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
abstract class AbstractContainer extends AbstractComponent
{
    protected $components = [];

    public function add(AbstractComponent $component)
    {
        $name = $component->getPropertyName();

        $this->components[$name] = $component;

        return $this;
    }

    public function hasComponent($name)
    {
        return isset($this->components[$name]);
    }

    public function getComponent($name)
    {
        return $this->components[$name];
    }

    public function getComponents()
    {
        return $this->components;
    }

    public function setData($data)
    {
        foreach ($this->components as $component) {
            $name = $component->getPropertyName();

            if (!isset($data[$name])) {
                continue;
            }

            $component->setData($data[$name]);
        }

        return $this;
    }
}
