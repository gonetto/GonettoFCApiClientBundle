<?php

namespace Gonetto\FCApiClientBundle\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class FinanceConsultContract
 *
 * @package Gonetto\FCApiClientBundle\Model
 */
class FinanceConsultContract
{

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
    protected $financeConsultContractNumber;

    /**
     * @var string (Zahlungsweise)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("zahlungsweise")
     */
    protected $paymentInterval;

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
     * @return FinanceConsultContract
     */
    public function setFee(float $fee): FinanceConsultContract
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
     * @return FinanceConsultContract
     */
    public function setInsurer(string $insurer): FinanceConsultContract
    {
        $this->insurer = $insurer;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getGonettoContractNumber(): ?string
    {
        return $this->gonettoContractNumber;
    }

    /**
     * @param string $gonettoContractNumber
     *
     * @return FinanceConsultContract
     */
    public function setGonettoContractNumber(string $gonettoContractNumber): FinanceConsultContract
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
     * @return FinanceConsultContract
     */
    public function setMainRenewalDate(\DateTime $mainRenewalDate): FinanceConsultContract
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
     * @return FinanceConsultContract
     */
    public function setInsuranceType(string $insuranceType): FinanceConsultContract
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
     * @return FinanceConsultContract
     */
    public function setContractDate(\DateTime $contractDate): FinanceConsultContract
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
     * @return FinanceConsultContract
     */
    public function setEndOfContract(\DateTime $endOfContract): FinanceConsultContract
    {
        $this->endOfContract = $endOfContract;

        return $this;
    }

    /**
     * @return string
     */
    public function getFinanceConsultContractNumber(): string
    {
        return $this->financeConsultContractNumber;
    }

    /**
     * @param string $financeConsultContractNumber
     *
     * @return FinanceConsultContract
     */
    public function setFinanceConsultContractNumber(string $financeConsultContractNumber): FinanceConsultContract
    {
        $this->financeConsultContractNumber = $financeConsultContractNumber;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPaymentInterval(): ?string
    {
        return $this->paymentInterval;
    }

    /**
     * @param string $paymentInterval
     *
     * @return FinanceConsultContract
     */
    public function setPaymentInterval(string $paymentInterval): FinanceConsultContract
    {
        $this->paymentInterval = $paymentInterval;

        return $this;
    }
}
