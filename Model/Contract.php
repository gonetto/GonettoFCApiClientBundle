<?php

namespace Gonetto\FCApiClientBundle\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Contract
 *
 * @package Gonetto\FCApiClientBundle\Model
 */
class Contract
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
     * @JMS\SerializedName("kundeID")
     */
    protected $customerId;

    /**
     * @var double
     *
     * @JMS\Type("double")
     * @JMS\SerializedName("beitrag")
     */
    protected $fee;

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("gesellschaft")
     */
    protected $insurer;

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("gonetto-id")
     *
     * @deprecated
     */
    protected $gonettoContractNumber;

    /**
     * @var \DateTime
     *
     * @JMS\Type("DateTime<'Y-m-d\TH:i:s', 'Europe/Berlin'>")
     * @JMS\SerializedName("hauptfälligkeit")
     */
    protected $mainRenewalDate;

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("produkt")
     */
    protected $insuranceType;

    /**
     * @var \DateTime
     *
     * @JMS\Type("DateTime<'Y-m-d\TH:i:s', 'Europe/Berlin'>")
     * @JMS\SerializedName("vermittlungsdatum")
     */
    protected $contractDate;

    /**
     * @var \DateTime
     *
     * @JMS\Type("DateTime<'Y-m-d\TH:i:s', 'Europe/Berlin'>")
     * @JMS\SerializedName("vertragsende")
     */
    protected $endOfContract;

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("vertragsnummer")
     */
    protected $contractNumber;

    /**
     * @var int
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("zahlungsweise")
     */
    protected $paymentInterval;

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
     * @return Contract
     */
    public function setFianceConsultId(string $fianceConsultId): Contract
    {
        $this->fianceConsultId = $fianceConsultId;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    /**
     * @param string $customerId
     *
     * @return Contract
     */
    public function setCustomerId(string $customerId): Contract
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * @return null|float
     */
    public function getFee(): ?float
    {
        return $this->fee;
    }

    /**
     * @param float $fee
     *
     * @return Contract
     */
    public function setFee(float $fee): Contract
    {
        $this->fee = $fee;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getInsurer(): ?string
    {
        return $this->insurer;
    }

    /**
     * @param string $insurer
     *
     * @return Contract
     */
    public function setInsurer(string $insurer): Contract
    {
        $this->insurer = $insurer;

        return $this;
    }

    /**
     * @return null|string
     *
     * @deprecated
     */
    public function getGonettoContractNumber(): ?string
    {
        return $this->gonettoContractNumber;
    }

    /**
     * @param string $gonettoContractNumber
     *
     * @return Contract
     *
     * @deprecated
     */
    public function setGonettoContractNumber(string $gonettoContractNumber): Contract
    {
        $this->gonettoContractNumber = $gonettoContractNumber;

        return $this;
    }

    /**
     * @return null|\DateTime
     */
    public function getMainRenewalDate(): ?\DateTime
    {
        return $this->mainRenewalDate;
    }

    /**
     * @param \DateTime $mainRenewalDate
     *
     * @return Contract
     */
    public function setMainRenewalDate(\DateTime $mainRenewalDate): Contract
    {
        $this->mainRenewalDate = $mainRenewalDate;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getInsuranceType(): ?string
    {
        return $this->insuranceType;
    }

    /**
     * @param string $insuranceType
     *
     * @return Contract
     */
    public function setInsuranceType(string $insuranceType): Contract
    {
        $this->insuranceType = $insuranceType;

        return $this;
    }

    /**
     * @return null|\DateTime
     */
    public function getContractDate(): ?\DateTime
    {
        return $this->contractDate;
    }

    /**
     * @param \DateTime $contractDate
     *
     * @return Contract
     */
    public function setContractDate(\DateTime $contractDate): Contract
    {
        $this->contractDate = $contractDate;

        return $this;
    }

    /**
     * @return null|\DateTime
     */
    public function getEndOfContract(): ?\DateTime
    {
        return $this->endOfContract;
    }

    /**
     * @param \DateTime $endOfContract
     *
     * @return Contract
     */
    public function setEndOfContract(\DateTime $endOfContract): Contract
    {
        $this->endOfContract = $endOfContract;

        return $this;
    }

    /**
     * @return string
     *
     * @deprecated
     * @see Contract::getContractNumber()
     */
    public function getFinanceConsultContractNumber(): string
    {
        return $this->getContractNumber();
    }

    /**
     * @param string $contractNumber
     *
     * @return Contract
     *
     * @deprecated
     * @see Contract::setContractNumber()
     */
    public function setFinanceConsultContractNumber(string $contractNumber): Contract
    {
        $this->setContractNumber($contractNumber);

        return $this;
    }

    /**
     * @return string
     */
    public function getContractNumber(): string
    {
        return $this->contractNumber;
    }

    /**
     * @param string $contractNumber
     *
     * @return Contract
     */
    public function setContractNumber(string $contractNumber): Contract
    {
        $this->contractNumber = $contractNumber;

        return $this;
    }

    /**
     * @return null|int|string
     */
    public function getPaymentInterval()
    {
        return $this->paymentInterval;
    }

    /**
     * @param int|string $paymentInterval
     *
     * @return \Gonetto\FCApiClientBundle\Model\Contract
     */
    public function setPaymentInterval($paymentInterval): Contract
    {
        $this->paymentInterval = $paymentInterval;

        return $this;
    }
}
