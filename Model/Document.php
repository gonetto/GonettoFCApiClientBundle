<?php

namespace Gonetto\FCApiClientBundle\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Document
 *
 * @package Gonetto\FCApiClientBundle\Model
 */
class Document
{

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("oid")
     */
    protected $fianceConsultId;

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("url")
     */
    protected $url;

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("art")
     */
    protected $type;

    /**
     * @var \DateTime
     *
     * @JMS\Type("DateTime<'Y-m-d\TH:i:s', 'Europe/Berlin'>")
     * @JMS\SerializedName("angelegt-am")
     */
    protected $addDate;

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("angelegt-von")
     */
    protected $addedBy;

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
     * @return Document
     */
    public function setFianceConsultId(string $fianceConsultId): Document
    {
        $this->fianceConsultId = $fianceConsultId;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return Document
     */
    public function setUrl(string $url): Document
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return Document
     */
    public function setType(string $type): Document
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getAddDate(): \DateTime
    {
        return $this->addDate;
    }

    /**
     * @param \DateTime $addDate
     *
     * @return Document
     */
    public function setAddDate(\DateTime $addDate): Document
    {
        $this->addDate = $addDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddedBy(): string
    {
        return $this->addedBy;
    }

    /**
     * @param string $addedBy
     *
     * @return Document
     */
    public function setAddedBy(string $addedBy): Document
    {
        $this->addedBy = $addedBy;

        return $this;
    }
}
