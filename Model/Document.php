<?php

namespace Gonetto\FCApiClientBundle\Model;

use DateTime;
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
     * @JMS\SerializedName("vertragID")
     */
    protected $contractId;

    /**
     * @var string
     *
     * @JMS\Type("integer")
     * @JMS\SerializedName("art")
     */
    protected $type;

    /**
     * @var \DateTime
     *
     * @JMS\Type("DateTime<'Y-m-d\TH:i:s', 'Europe/Berlin'>")
     * @JMS\SerializedName("datum")
     */
    protected $date;

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
    public function setFianceConsultId(string $fianceConsultId): self
    {
        $this->fianceConsultId = $fianceConsultId;

        return $this;
    }

    /**
     * @return string
     */
    public function getContractId(): string
    {
        return $this->contractId;
    }

    /**
     * @param string $contractId
     *
     * @return Document
     */
    public function setContractId(string $contractId): self
    {
        $this->contractId = $contractId;

        return $this;
    }

    /**
     * @return null|int|string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int|string $type
     *
     * @return Document
     */
    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     *
     * @return Document
     */
    public function setDate(DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }
}
