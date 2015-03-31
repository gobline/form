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
class UploadedFile
{
    private $filename; // stores the file name without the extension
    private $tmpPath;
    private $size = 0;
    private $type = '';
    private $extension = '';
    private $error;

    public function __construct(array $data)
    {
        $this->setError($data['error']);
        if ($data['error'] === 0) {
            $this->setError($data['error']);
            $this->setBasename($data['name']);
            $this->setType($data['type']);
            $this->setTmpPath($data['tmp_name']);
            $this->setSize($data['size']);
        }
    }
    
    public function setFilename($filename) 
    {
        $this->filename = $filename;
    }

    public function getFilename() 
    {
        return $this->filename;
    }

    public function setBasename($basename)
    {
        $pathParts = pathinfo($basename);
        $this->extension = $pathParts['extension'];
        $this->filename = $pathParts['filename'];
    }

    public function getBasename() 
    {
        return $this->filename . '.' . $this->extension;
    }

    public function setTmpPath($tmpPath) 
    {
        $this->tmpPath = $tmpPath;
    }

    public function getTmpPath() 
    {
        return $this->tmpPath;
    }

    public function setSize($size) 
    {
        $this->size = $size;
    }

    public function getSize() 
    {
        return $this->size;
    }

    public function setError($error) 
    {
        $this->error = $error;
    }

    public function getError() 
    {
        return $this->error;
    }

    public function hasError() 
    {
        return ($this->error !== 0);
    }

    public function setType($type) 
    {
        $this->type = $type;
    }

    public function getType() 
    {
        return $this->type;
    }

    public function setExtension($extension) 
    {
        $this->extension = $extension;
    }

    public function getExtension() 
    {
        return $this->extension;
    }
}
