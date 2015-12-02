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

use Gobline\Form\UploadedFile;
use Psr\Http\Message\UploadedFileInterface;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class File extends AbstractElement
{
    protected $uploadedFile;

    public function __construct($name)
    {
        parent::__construct($name);

        $this->attributes['type'] = 'file';
    }

    public function __toString()
    {
        $string = '<input';
        foreach ($this->attributes as $attribute => $value) {
            $string .= ' '.$attribute.'="'.$value.'"';
        }

        return $string.">\n";
    }

    public function setValue($value)
    {
        if (!$value instanceof UploadedFileInterface) {
            throw new \RuntimeException();
        }

        $this->uploadedFile = $value;

        return $this;
    }

    public function getValue()
    {
        return $this->uploadedFile;
    }

    public function setFilters($filters)
    {
        $this->rules = $filters;

        return $this;
    }

    public function __call($name, array $arguments)
    {
        if (is_callable([$this->uploadedFile, $name])) {
            return $this->uploadedFile->$name(...$arguments);
        }
    }
}
