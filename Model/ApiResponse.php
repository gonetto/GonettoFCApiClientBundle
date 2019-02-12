<?php

namespace Gonetto\FCApiClientBundle\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class ApiResponse
 *
 * @package Gonetto\FCApiClientBundle\Model
 */
class ApiResponse
{

    /**
     * @var array
     *
     * @JMS\Type("array<Gonetto\FCApiClientBundle\Model\Customer>")
     * @JMS\SerializedName("kunden")
     */
    protected $customers;

    /**
     * @var array
     *
     * @JMS\Type("array<Gonetto\FCApiClientBundle\Model\Contract>")
     * @JMS\SerializedName("verträge")
     */
    protected $contracts = [];

    /**
     * @var array
     *
     * @JMS\Type("array<Gonetto\FCApiClientBundle\Model\Document>")
     * @JMS\SerializedName("dokumente")
     */
    protected $documents = [];

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
     * @return ApiResponse
     */
    public function setCustomers(array $customers): ApiResponse
    {
        $this->customers = $customers;

        return $this;
    }

    /**
     * @param Customer $customer
     *
     * @return ApiResponse
     */
    public function addCustomer(Customer $customer): ApiResponse
    {
        $this->customers[] = $customer;

        return $this;
    }

    /**
     * @param Customer $customer
     *
     * @return ApiResponse
     */
    public function removeCustomer(Customer $customer): ApiResponse
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

    /**
     * @return array
     */
    public function getContracts(): array
    {
        return $this->contracts;
    }

    /**
     * @param array $contracts
     *
     * @return Customer
     */
    public function setContracts(array $contracts): ApiResponse
    {
        $this->contracts = $contracts;

        return $this;
    }

    /**
     * @param Contract $contract
     *
     * @return Customer
     */
    public function addContract(Contract $contract): ApiResponse
    {
        $this->contracts[] = $contract;

        return $this;
    }

    /**
     * @param Contract $contract
     *
     * @return Customer
     */
    public function removeContract(Contract $contract): ApiResponse
    {
        /** @var \Gonetto\FCApiClientBundle\Model\Contract $currentContract */
        foreach ($this->contracts as $key => $currentContract) {
            if ($contract->getContractNumber() === $currentContract->getContractNumber()) {
                unset($this->contracts[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getDocuments(): array
    {
        return $this->documents;
    }

    /**
     * @param array $documents
     *
     * @return Customer
     */
    public function setDocuments(array $documents): ApiResponse
    {
        $this->documents = $documents;

        return $this;
    }

    /**
     * @param Document $contract
     *
     * @return Customer
     */
    public function addDocument(Document $contract): ApiResponse
    {
        $this->documents[] = $contract;

        return $this;
    }

    /**
     * @param Document $contract
     *
     * @return Customer
     */
    public function removeDocument(Document $contract): ApiResponse
    {
        /** @var \Gonetto\FCApiClientBundle\Model\Document $currentDocument */
        foreach ($this->documents as $key => $currentDocument) {
            if ($contract->getFianceConsultId() === $currentDocument->getFianceConsultId()) {
                unset($this->documents[$key]);
                break;
            }
        }

        return $this;
    }
}
