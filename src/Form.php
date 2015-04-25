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
        return $this->getRecursively($name, $this->components);
    }

    private function getRecursively($name, array $components)
    {
        if (array_key_exists($name, $components)) {
            $component = $components[$name];

            if ($component instanceof FieldSet) {
                return $component->getEntity($name);
            }

            return $component->getValue();
        }

        foreach ($components as $component) {
            if ($component instanceof FieldSet) {
                $result = $this->getRecursively($name, $component->getComponents($name));
                if ($result) {
                    return $result;
                }
            }
        }
    }

    public function populate($fieldSet, $entity)
    {
        $fieldSet = $this->components[$fieldSet];

        $fieldSet->populate($entity);
    }

    public function setEntity($fieldSet, $entity)
    {
        $fieldSet = $this->components[$fieldSet];

        $fieldSet->setEntity($entity);
    }

    public function validate($data = null)
    {
        if ($data) {
            $this->setData($data);
        }

        $this->messages = [];
        $this->validateRecursively($this->components);

        return !$this->messages;
    }

    private function validateRecursively(array $components = [])
    {
        foreach ($components as $component) {
            if ($component instanceof FieldSet) {
                $this->validateRecursively($component->getComponents());
            } else {
                $objectFilter = new ObjectFilter();
                $objectFilter->filter(clone $component);

                if ($objectFilter->hasMessages()) {
                    $errors = $objectFilter->getMessages();

                    $tmpErrors = [];
                    $componentName = $component->getAttribute('name');
                    $tmpErrors[$componentName] = [];
                    foreach ($errors as $property => $messages) {
                        $component->addErrors($messages);
                        $tmpErrors[$componentName] = 
                            array_merge(
                                $tmpErrors[$componentName], 
                                $errors[$property]);
                    }

                    $this->messages = array_merge($this->messages, $tmpErrors);
                }
            }
        }
    }

    public function getMessages()
    {
        return $this->messages;
    }
}
