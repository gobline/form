<?php

/*
 * Gobline Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gobline\Form;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class Form extends AbstractContainer
{
    protected $validator;
    protected $dataFetcher;

    public function __construct()
    {
        $this->setAttribute('method', 'get');

        $this->validator = new FormValidator();
        $this->dataFetcher = new FormDataFetcher();
    }

    public function add(AbstractComponent $component)
    {
        if (
            $component instanceof FieldSet &&
            !$component->isNamespaced()
        ) {
            $this->components = array_merge($this->components, $component->getComponents());
        }

        parent::add($component);

        return $this;
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

    public function getValue($name)
    {
        if (!$this->dataFetcher) {
            throw new \RuntimeException('Form has not been initialized');
        }

        return $this->dataFetcher->get($name, $this->components, FormDataFetcher::FETCH_VALUE);
    }

    public function getEntity($name)
    {
        if (!$this->dataFetcher) {
            throw new \RuntimeException('Form has not been initialized');
        }

        return $this->dataFetcher->get($name, $this->components, FormDataFetcher::FETCH_ENTITY);
    }

    public function setEntity($fieldSet, $entity)
    {
        $fieldSet = $this->components[$fieldSet];

        $fieldSet->setEntity($entity);
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

        if (!$this->validator) {
            throw new \RuntimeException('Form has not been initialized');
        }

        return $this->validator->validate($this->components);
    }

    public function getMessages()
    {
        if (!$this->validator) {
            throw new \RuntimeException('Form has not been initialized');
        }

        return $this->validator->getMessages();
    }
}
