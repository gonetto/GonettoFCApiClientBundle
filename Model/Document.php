<?php

namespace Gonetto\FCApiClientBundle\Model;

use DateTime;
use JMS\Serializer\Annotation as JMS;

/**
 * Class Document
 *
 * @package Gonetto\FCApiClientBundle\Model
 */
class Document implements EntityInterface
{

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("oid")
     */
    protected $financeConsultId;

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
     *
     * @deprecated
     * @see Document::getFinanceConsultId()
     */
    public function getFianceConsultId(): string
    {
        return $this->financeConsultId;
    }

    /**
     * @return string
     */
    public function getFinanceConsultId(): string
    {
        return $this->financeConsultId;
    }

    /**
     * @param string $financeConsultId
     *
     * @return Document
     *
     * @deprecated
     * @see Document::setFinanceConsultId()
     */
    public function setFianceConsultId(string $financeConsultId): self
    {
        $this->financeConsultId = $financeConsultId;

        return $this;
    }

    /**
     * @param string $financeConsultId
     *
     * @return Document
     */
    public function setFinanceConsultId(string $financeConsultId): self
    {
        $this->financeConsultId = $financeConsultId;

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
