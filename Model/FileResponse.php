<?php

namespace Gonetto\FCApiClientBundle\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class FileResponse
 *
 * @package Gonetto\FCApiClientBundle\Model
 */
class FileResponse
{

    /**
     * @var string Base64 encoded document
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("data")
     */
    protected $file;

    /**
     * @var string e.g. PDF
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("extension")
     */
    protected $extension;

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @param string $file
     *
     * @return FileResponse
     */
    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     *
     * @return FileResponse
     */
    public function setExtension(string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }
}
