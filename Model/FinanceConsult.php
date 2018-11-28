<?php

namespace Gonetto\FCApiClientBundle\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class FinanceConsult
 *
 * @package Gonetto\FCApiClientBundle\Model
 */
class FinanceConsult
{

    /**
     * @var array
     *
     * @JMS\Type("array<Gonetto\FCApiClientBundle\Model\FinanceConsultCustomer>")
     * @JMS\SerializedName("kunden")
     */
    protected $customers;

    /**
     * @return array
     */
    public function getCustomers(): array
    {
        return $this->customers;
    }

    /**
     * @param array $customers
     *
     * @return FinanceConsult
     */
    public function setCustomers(array $customers): FinanceConsult
    {
        $this->customers = $customers;

        return $this;
    }

    /**
     * @param FinanceConsultCustomer $customer
     *
     * @return FinanceConsult
     */
    public function addCustomer(FinanceConsultCustomer $customer): FinanceConsult
    {
        $this->customers[] = $customer;

        return $this;
    }

    /**
     * @param FinanceConsultCustomer $customer
     *
     * @return FinanceConsult
     */
    public function removeCustomer(FinanceConsultCustomer $customer): FinanceConsult
    {
        /**  @var \Gonetto\FCApiClientBundle\Model\FinanceConsultCustomer $currentCustomer */
        foreach ($this->customers as $key => $currentCustomer) {
            if ($customer->getEmail() === $currentCustomer->getEmail()) {
                unset($this->customers[$key]);
                break;
            }
        }

        return $this;
    }
}
