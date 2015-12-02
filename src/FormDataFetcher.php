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
class FormDataFetcher
{
    const FETCH_ANY = 0;
    const FETCH_VALUE = 1;
    const FETCH_ENTITY = 2;

    public function get($name, $components, $mode)
    {
        if (array_key_exists($name, $components)) {
            $component = $components[$name];

            if ($component instanceof FieldSet) {
                if ($mode === self::FETCH_ENTITY || $mode === self::FETCH_ANY) {
                    return $component->getEntity($name);
                }

                throw new \RuntimeException('Form data "'.$name.'" is an entity');
            }

            if ($mode === self::FETCH_VALUE || $mode === self::FETCH_ANY) {
                return $component->getValue();
            }

            throw new \RuntimeException('Form data "'.$name.'" is a value');
        }

        throw new \RuntimeException('Form data "'.$name.'" not found');
    }
}
