<?php

namespace Gonetto\FCApiClientBundle\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class FinanceConsultResponse
 *
 * @package Gonetto\FCApiClientBundle\Model
 */
class FinanceConsultResponse
{

    /**
     * @var array
     *
     * @JMS\Type("array<Gonetto\FCApiClientBundle\Model\Customer>")
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
     * @return FinanceConsultResponse
     */
    public function setCustomers(array $customers): FinanceConsultResponse
    {
        $this->customers = $customers;

        return $this;
    }

    /**
     * @param Customer $customer
     *
     * @return FinanceConsultResponse
     */
    public function addCustomer(Customer $customer): FinanceConsultResponse
    {
        $this->customers[] = $customer;

        return $this;
    }

    /**
     * @param Customer $customer
     *
     * @return FinanceConsultResponse
     */
    public function removeCustomer(Customer $customer): FinanceConsultResponse
    {
        /**  @var \Gonetto\FCApiClientBundle\Model\Customer $currentCustomer */
        foreach ($this->customers as $key => $currentCustomer) {
            if ($customer->getEmail() === $currentCustomer->getEmail()) {
                unset($this->customers[$key]);
                break;
            }
        }

        return $this;
    }
}
