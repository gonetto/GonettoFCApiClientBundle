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
     * @var string
     *
     * @JMS\Type("integer")
     * @JMS\SerializedName("art")
     */
    protected $documentType;

    /**
     * @var \DateTime created at date
     *
     * @JMS\Type("DateTime<'Y-m-d', 'Europe/Berlin'>")
     * @JMS\SerializedName("erstelltAm")
     */
    protected $created;

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
     * @return int
     */
    public function getDocumentType(): int
    {
        return $this->documentType;
    }

    /**
     * @param int $documentType
     *
     * @return FileResponse
     */
    public function setDocumentType(int $documentType): FileResponse
    {
        $this->documentType = $documentType;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     *
     * @return \Gonetto\FCApiClientBundle\Model\FileResponse
     * @throws \Exception
     */
    public function setCreated(\DateTime $created): FileResponse
    {
        $this->created = $created;

        return $this;
    }

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
    public function setFile(string $file): FileResponse
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
    public function setExtension(string $extension): FileResponse
    {
        $this->extension = $extension;

        return $this;
    }
}
