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
     * @JMS\Type("DateTime<'Y-m-d\TH:i:s', 'Europe/Berlin'>")
     * @JMS\SerializedName("erstelltAm")
     */
    protected $created;

    /**
     * @var string Base64 encoded document
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("data")
     */
    protected $fianceConsultId;

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
    public function getDocumentType(): string
    {
        return $this->documentType;
    }

    /**
     * @param string $documentType
     *
     * @return FileResponse
     */
    public function setDocumentType(string $documentType): FileResponse
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
     * @return FileResponse
     */
    public function setCreated(\DateTime $created): FileResponse
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return string
     */
    public function getFianceConsultId(): string
    {
        return $this->fianceConsultId;
    }

    /**
     * @param string $fianceConsultId
     *
     * @return FileResponse
     */
    public function setFianceConsultId(string $fianceConsultId): FileResponse
    {
        $this->fianceConsultId = $fianceConsultId;

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
