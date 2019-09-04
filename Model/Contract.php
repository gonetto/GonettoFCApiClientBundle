<?php

namespace Gonetto\FCApiClientBundle\Model;

use DateTime;
use JMS\Serializer\Annotation as JMS;

/**
 * Class Contract
 *
 * @package Gonetto\FCApiClientBundle\Model
 */
class Contract implements EntityInterface
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
    protected $policyNumber;

    /**
     * @var int
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("zahlungsweise")
     */
    protected $paymentInterval;

    /**
     * @return string
     *
     * @deprecated
     * @see Contract::getFinanceConsultId()
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
     * @return Contract
     *
     * @deprecated
     * @see Contract::setFinanceConsultId()
     */
    public function setFianceConsultId(string $financeConsultId): self
    {
        $this->financeConsultId = $financeConsultId;

        return $this;
    }

    /**
     * @param string $financeConsultId
     *
     * @return Contract
     */
    public function setFinanceConsultId(string $financeConsultId): self
    {
        $this->financeConsultId = $financeConsultId;

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
    public function setCustomerId(string $customerId): self
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
    public function setFee(float $fee): self
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
    public function setInsurer(string $insurer): self
    {
        $this->insurer = $insurer;

        return $this;
    }

    /**
     * @return null|\DateTime
     */
    public function getMainRenewalDate(): ?DateTime
    {
        return $this->mainRenewalDate;
    }

    /**
     * @param \DateTime $mainRenewalDate
     *
     * @return Contract
     */
    public function setMainRenewalDate(DateTime $mainRenewalDate): self
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
    public function setInsuranceType(string $insuranceType): self
    {
        $this->insuranceType = $insuranceType;

        return $this;
    }

    /**
     * @return null|\DateTime
     */
    public function getContractDate(): ?DateTime
    {
        return $this->contractDate;
    }

    /**
     * @param \DateTime $contractDate
     *
     * @return Contract
     */
    public function setContractDate(DateTime $contractDate): self
    {
        $this->contractDate = $contractDate;

        return $this;
    }

    /**
     * @return null|\DateTime
     */
    public function getEndOfContract(): ?DateTime
    {
        return $this->endOfContract;
    }

    /**
     * @param \DateTime $endOfContract
     *
     * @return Contract
     */
    public function setEndOfContract(DateTime $endOfContract): self
    {
        $this->endOfContract = $endOfContract;

        return $this;
    }

    /**
     * @return string
     */
    public function getPolicyNumber(): string
    {
        return $this->policyNumber;
    }

    /**
     * @param string $policyNumber
     *
     * @return Contract
     */
    public function setPolicyNumber(string $policyNumber): self
    {
        $this->policyNumber = $policyNumber;

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
    public function setPaymentInterval($paymentInterval): self
    {
        $this->paymentInterval = $paymentInterval;

        return $this;
    }
}
