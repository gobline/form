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

use Mendo\Form\Element\AbstractElement;
use Mendo\Filter\ObjectFilter;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class Form extends AbstractContainer
{
    protected $messages = [];

    public function __construct()
    {
        $this->setAttribute('method', 'get');
    }

    public function setMethod($method)
    {
        $this->setAttribute('method', $method);

        return $this;
    }

    public function setAction($action)
    {
        $this->setAttribute('action', $action);

        return $this;
    }

    public function setEnctype($type)
    {
        $this->setAttribute('enctype', $type);

        return $this;
    }

    public function get($name)
    {
        $component = $this->components[$name];

        if ($component instanceof FieldSet) {
            return $component->getEntity($name);
        }

        return $component->getValue();
    }

    public function populate($fieldSet, $entity)
    {
        $fieldSet = $this->components[$fieldSet];

        $fieldSet->populate($entity);
    }

    public function validate($data = null)
    {
        if ($data) {
            $this->setData($data);
        }

        $this->messages = [];

        $this->validateComponents($this->components);

        return !$this->messages;
    }

    private function validateComponents(array $components = [])
    {
        foreach ($components as $component) {
            if ($component instanceof FieldSet) {
                $this->validateComponents($component->getComponents());
            } else {
                $objectFilter = new ObjectFilter();
                $objectFilter->filter(clone $component);

                if ($objectFilter->hasMessages()) {
                    $errors = $objectFilter->getMessages();

                    $component->setErrors($errors['value']);

                    $errors[$component->getAttribute('name')] = $errors['value'];
                    unset($errors['value']);

                    $this->messages = array_merge($this->messages, $errors);
                }
            }
        }
    }

    public function getMessages()
    {
        return $this->messages;
    }
}
