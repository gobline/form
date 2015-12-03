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

use Gobline\Filter\ObjectFilter;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class FormValidator
{
    private $messages = [];

    public function validate($components)
    {
        $this->messages = [];
        $this->validateRecursively($components);

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
                    $componentName = $component->getPropertyName();
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
