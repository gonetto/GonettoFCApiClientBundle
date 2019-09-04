<?php

namespace Gonetto\FCApiClientBundle\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Customer
 *
 * @package Gonetto\FCApiClientBundle\Model
 */
class CustomerUpdateRequest extends Customer implements RequestInterface
{

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("token")
     */
    protected $token;

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("action")
     */
    protected $action = 'setKunde';

    /**
     * Info for Finance Consult, to redirect the customer address to the insurances.
     *
     * @var bool
     *
     * @JMS\Type("boolean")
     * @JMS\SerializedName("gesellschaftInformierenAdresse")
     */
    protected $informCompanyAboutAddress = false;

    /**
     * Info for Finance Consult, to redirect the customer IBAN to the insurances.
     *
     * @var bool
     *
     * @JMS\Type("boolean")
     * @JMS\SerializedName("gesellschaftInformierenBank")
     */
    protected $informCompanyAboutBank = false;

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function isInformCompanyAboutAddress(): bool
    {
        return $this->informCompanyAboutAddress;
    }

    public function setInformCompanyAboutAddress(bool $informCompanyAboutAddress): self
    {
        $this->informCompanyAboutAddress = $informCompanyAboutAddress;

        return $this;
    }

    public function isInformCompanyAboutBank(): bool
    {
        return $this->informCompanyAboutBank;
    }

    public function setInformCompanyAboutBank(bool $informCompanyAboutBank): self
    {
        $this->informCompanyAboutBank = $informCompanyAboutBank;

        return $this;
    }
}
