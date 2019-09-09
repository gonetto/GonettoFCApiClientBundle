<?php

namespace Gonetto\FCApiClientBundle\Model;

use JMS\Serializer\Annotation as JMS;

class CustomerUpdate extends Customer
{

    /**
     * Info for Finance Consult, to redirect the customer address to the insurances.
     *
     * @var bool
     *
     * @JMS\Type("boolean")
     * @JMS\SerializedName("gesellschaftInformierenAdresse")
     */
    protected $informInsurerAboutAddress = false;

    /**
     * Info for Finance Consult, to redirect the customer IBAN to the insurances.
     *
     * @var bool
     *
     * @JMS\Type("boolean")
     * @JMS\SerializedName("gesellschaftInformierenBank")
     */
    protected $informInsurerAboutBank = false;

    public function clone(CustomerUpdate $customer): self
    {
        foreach (get_object_vars($customer) as $key => $value) {
            $this->$key = $value;
        }

        return $this;
    }

    public function isInformInsurerAboutAddress(): bool
    {
        return $this->informInsurerAboutAddress;
    }

    public function setInformInsurerAboutAddress(bool $informInsurerAboutAddress): self
    {
        $this->informInsurerAboutAddress = $informInsurerAboutAddress;

        return $this;
    }

    public function isInformInsurerAboutBank(): bool
    {
        return $this->informInsurerAboutBank;
    }

    public function setInformInsurerAboutBank(bool $informInsurerAboutBank): self
    {
        $this->informInsurerAboutBank = $informInsurerAboutBank;

        return $this;
    }
}
