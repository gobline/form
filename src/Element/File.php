<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mendo\Form\Element;

use Mendo\Form\UploadedFile;

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
        $this->uploadedFile = new UploadedFile($value);

        return $this;
    }

    public function getValue()
    {
        return $this->uploadedFile;
    }

    public function __call($name, array $arguments)
    {
        return $this->uploadedFile->$name(...$arguments);
    }
}
