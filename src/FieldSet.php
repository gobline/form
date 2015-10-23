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

use Mendo\Filter\FilterableInterface;
use Mendo\Form\Element\AbstractElement;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class FieldSet extends AbstractContainer
{
    protected $entity;
    protected $legend;
    protected $namespaced = true;

    public function __construct($name)
    {
        parent::__construct($name);
    }

    public function setData($data)
    {
        $this->prepareFilters();

        parent::setData($data);
    }

    public function add(AbstractComponent $component)
    {
        parent::add($component);

        if ($this->namespaced) {
            $this->updateElementsNamespace($this->getPropertyName(), $component);
        }

        if ($component instanceof AbstractElement) {
            $component->setFieldSet($this);
        }

        return $this;
    }

    public function setNamespaced($namespaced)
    {
        $this->namespaced = $namespaced;
    }

    public function isNamespaced()
    {
        return $this->namespaced;
    }

    private function updateElementsNamespace($fieldSetName, AbstractComponent $component)
    {
        if ($component instanceof AbstractElement) {
            $name = $component->getAttribute('name');

            $pos = strpos($name, '[');
            if ($pos !== false) {
                $name = $fieldSetName.'['.substr($name, 0, $pos).']'.substr($name, $pos);
            } else {
                $name = $fieldSetName.'['.$name.']';
            }

            $component->setAttribute('name', $name);

            return;
        }

        foreach ($component->getComponents() as $c) {
            $component->updateElementsNamespace($fieldSetName, $c);
        }
    }

    public function setEntity($entity)
    {
        // http://www.doctrine-project.org/2010/03/21/doctrine-2-give-me-my-constructor-back.html
        if (is_string($entity)) {
            $entity = clone unserialize(sprintf('O:%d:"%s":0:{}', strlen($entity), $entity));
        }

        $this->entity = $entity;

        return $entity;
    }

    public function prepareFilters()
    {
        if ($this->entity instanceof FilterableInterface) {
            $rules = $this->entity->getRules();
            foreach ($rules as $property => $filters) {
                if ($this->hasComponent($property)) {
                    $this->getComponent($property)->setFilters($filters);
                }
            }
        }
    }

    public function populate($entity)
    {
        $this->setEntity($entity);

        $vars = get_object_vars($entity);

        foreach ($vars as $property => $value) {
            if ($this->hasComponent($property)) {
                $component = $this->getComponent($property);

                if ($component instanceof AbstractElement) {
                    $component->setValue($value);
                } else {
                    $component->populate($value);
                }
            }
        }

        $methods = get_class_methods($entity);

        foreach ($methods as $method) {
            if ($this->startsWith($method, 'get')) {
                $property = lcfirst(substr($method, 3));
            } elseif ($this->startsWith($method, 'is')) {
                $property = lcfirst(substr($method, 2));
            } elseif ($this->startsWith($method, 'has')) {
                $property = lcfirst(substr($method, 3));
            } else {
                continue;
            }

            if ($this->hasComponent($property)) {
                $component = $this->getComponent($property);

                $value = $entity->$method();

                if ($component instanceof AbstractElement) {
                    $component->setValue($value);
                } else {
                    $component->populate($value);
                }
            }
        }
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function updateEntity(AbstractElement $element)
    {
        $property = $element->getPropertyName();
        $value = $element->getValue();

        $setter = 'set'.ucfirst($property);
        if (is_callable([$this->entity, $setter])) {
            $this->entity->$setter($value);
        } else {
            $reflectionObject = new \ReflectionObject($this->entity);
            if (
                $reflectionObject->hasProperty($property) && 
                $reflectionObject->getProperty($property)->isPublic()
            ) {
                $this->entity->$property = $value;
            }
        }
    }

    public function getLegend()
    {
        return $this->legend;
    }

    public function setLegend($legend)
    {
        $this->legend = $legend;

        return $this;
    }

    private function startsWith($haystack, $needle)
    {
        return $needle === '' || strpos($haystack, $needle) === 0;
    }
}
