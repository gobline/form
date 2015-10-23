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

use Mendo\Translator\TranslatorInterface;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
abstract class AbstractComponent
{
    protected $attributes = [];
    protected $propertyName;
    private $translator;
    private static $defaultTranslator;

    public function __construct($name)
    {
        $this->propertyName = $name;
    }

    public function getPropertyName()
    {
        return $this->propertyName;
    }

    public function setPropertyName($propertyName)
    {
        $this->propertyName = $propertyName;
    }

    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    public function removeAttribute($name)
    {
        unset($this->attributes[$name]);

        return $this;
    }

    public function getAttribute($name)
    {
        if (!$this->hasAttribute($name)) {
            return '';
        }

        return $this->attributes[$name];
    }

    public function hasAttribute($name)
    {
        return isset($this->attributes[$name]);
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    abstract public function setData($data);

    /**
     * @return TranslatorInterface
     */
    public function getTranslator()
    {
        if ($this->translator) {
            return $this->translator;
        }

        if (self::$defaultTranslator) {
            return self::$defaultTranslator;
        }

        return null;
    }

    /**
     * @param TranslatorInterface $translator
     */
    public function setTranslator(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param TranslatorInterface $translator
     */
    public static function setDefaultTranslator(TranslatorInterface $translator)
    {
        self::$defaultTranslator = $translator;
    }
}
