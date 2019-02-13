<?php

namespace Gonetto\FCApiClientBundle\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class DataResponse
 *
 * @package Gonetto\FCApiClientBundle\Model
 */
class DataResponse
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
     * @JMS\SerializedName("vertraege")
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
     * @return DataResponse
     */
    public function setCustomers(array $customers): DataResponse
    {
        $this->customers = $customers;

        return $this;
    }

    /**
     * @param Customer $customer
     *
     * @return DataResponse
     */
    public function addCustomer(Customer $customer): DataResponse
    {
        $this->customers[] = $customer;

        return $this;
    }

    /**
     * @param Customer $customer
     *
     * @return DataResponse
     */
    public function removeCustomer(Customer $customer): DataResponse
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
     * @return DataResponse
     */
    public function setContracts(array $contracts): DataResponse
    {
        $this->contracts = $contracts;

        return $this;
    }

    /**
     * @param Contract $contract
     *
     * @return DataResponse
     */
    public function addContract(Contract $contract): DataResponse
    {
        $this->contracts[] = $contract;

        return $this;
    }

    /**
     * @param Contract $contract
     *
     * @return DataResponse
     */
    public function removeContract(Contract $contract): DataResponse
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
     * @return DataResponse
     */
    public function setDocuments(array $documents): DataResponse
    {
        $this->documents = $documents;

        return $this;
    }

    /**
     * @param Document $contract
     *
     * @return DataResponse
     */
    public function addDocument(Document $contract): DataResponse
    {
        $this->documents[] = $contract;

        return $this;
    }

    /**
     * @param Document $contract
     *
     * @return DataResponse
     */
    public function removeDocument(Document $contract): DataResponse
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
