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
    protected $customers = [];

    /**
     * @var array
     *
     * @JMS\Type("array<string>")
     * @JMS\SerializedName("kundenDeleted")
     */
    protected $customersDeleted;

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
     * @JMS\Type("array<string>")
     * @JMS\SerializedName("vertraegeDeleted")
     */
    protected $contractsDeleted;

    /**
     * @var array
     *
     * @JMS\Type("array<Gonetto\FCApiClientBundle\Model\Document>")
     * @JMS\SerializedName("dokumente")
     */
    protected $documents = [];

    /**
     * @var array
     *
     * @JMS\Type("array<string>")
     * @JMS\SerializedName("dokumenteDeleted")
     */
    protected $documentsDeleted;

    /**
     * @return array
     * TODO:GN: add to all parameters in all objects the array content phpdocs. E.g. \Gonetto\FCApiClientBundle\Model\Customer[] instead array
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
    public function setCustomers(array $customers): self
    {
        $this->customers = $customers;

        return $this;
    }

    /**
     * @param Customer $customer
     *
     * @return DataResponse
     */
    public function addCustomer(Customer $customer): self
    {
        $this->customers[] = $customer;

        return $this;
    }

    /**
     * @param Customer $customer
     *
     * @return DataResponse
     */
    public function removeCustomer(Customer $customer): self
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
    public function getCustomersDeleted(): array
    {
        return $this->customersDeleted;
    }

    /**
     * @param array $customersDeleted
     *
     * @return DataResponse
     */
    public function setCustomersDeleted(array $customersDeleted): self
    {
        $this->customersDeleted = $customersDeleted;

        return $this;
    }

    /**
     * @param string $customer_id
     *
     * @return DataResponse
     */
    public function addCustomerDeleted(string $customer_id): self
    {
        $this->customersDeleted[] = $customer_id;

        return $this;
    }

    /**
     * @param string $customer_id
     *
     * @return DataResponse
     */
    public function removeCustomerDeleted(string $customer_id): self
    {
        foreach ($this->customersDeleted as $key => $current_customer_id) {
            if ($customer_id === $current_customer_id) {
                unset($this->customersDeleted[$key]);
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
    public function setContracts(array $contracts): self
    {
        $this->contracts = $contracts;

        return $this;
    }

    /**
     * @param Contract $contract
     *
     * @return DataResponse
     */
    public function addContract(Contract $contract): self
    {
        $this->contracts[] = $contract;

        return $this;
    }

    /**
     * @param Contract $contract
     *
     * @return DataResponse
     */
    public function removeContract(Contract $contract): self
    {
        /** @var \Gonetto\FCApiClientBundle\Model\Contract $currentContract */
        foreach ($this->contracts as $key => $currentContract) {
            if ($contract->getPolicyNumber() === $currentContract->getPolicyNumber()) {
                unset($this->contracts[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getContractsDeleted(): array
    {
        return $this->contractsDeleted;
    }

    /**
     * @param array $contractsDeleted
     *
     * @return DataResponse
     */
    public function setContractsDeleted(array $contractsDeleted): self
    {
        $this->contractsDeleted = $contractsDeleted;

        return $this;
    }

    /**
     * @param string $contract_id
     *
     * @return DataResponse
     */
    public function addContractDeleted(string $contract_id): self
    {
        $this->contractsDeleted[] = $contract_id;

        return $this;
    }

    /**
     * @param string $contract_id
     *
     * @return DataResponse
     */
    public function removeContractDeleted(string $contract_id): self
    {
        foreach ($this->contractsDeleted as $key => $current_contract_id) {
            if ($contract_id === $current_contract_id) {
                unset($this->contractsDeleted[$key]);
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
    public function setDocuments(array $documents): self
    {
        $this->documents = $documents;

        return $this;
    }

    /**
     * @param Document $contract
     *
     * @return DataResponse
     */
    public function addDocument(Document $contract): self
    {
        $this->documents[] = $contract;

        return $this;
    }

    /**
     * @param Document $contract
     *
     * @return DataResponse
     */
    public function removeDocument(Document $contract): self
    {
        /** @var \Gonetto\FCApiClientBundle\Model\Document $currentDocument */
        foreach ($this->documents as $key => $currentDocument) {
            if ($contract->getFinanceConsultId() === $currentDocument->getFinanceConsultId()) {
                unset($this->documents[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getDocumentsDeleted(): array
    {
        return $this->documentsDeleted;
    }

    /**
     * @param array $documentsDeleted
     *
     * @return DataResponse
     */
    public function setDocumentsDeleted(array $documentsDeleted): self
    {
        $this->documentsDeleted = $documentsDeleted;

        return $this;
    }

    /**
     * @param string $document_id
     *
     * @return DataResponse
     */
    public function addDocumentDeleted(string $document_id): self
    {
        $this->documentsDeleted[] = $document_id;

        return $this;
    }

    /**
     * @param string $document_id
     *
     * @return DataResponse
     */
    public function removeDocumentDeleted(string $document_id): self
    {
        foreach ($this->documentsDeleted as $key => $current_document_id) {
            if ($document_id === $current_document_id) {
                unset($this->documentsDeleted[$key]);
                break;
            }
        }

        return $this;
    }
}
