<?php

namespace Gonetto\FCApiClientBundle\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Customer
 *
 * @package Gonetto\FCApiClientBundle\Model
 */
class Customer
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
     */
    protected $email;

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("vorname")
     */
    protected $firstName;

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("nachname")
     */
    protected $lastName;

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("firma")
     */
    protected $company;

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("strasse")
     */
    protected $street;

    /**
     * @var string
     */
    protected $houseNumber;

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("plz")
     */
    protected $zipCode;

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("ort")
     */
    protected $city;

    /**
     * @var string
     *
     * @JMS\Type("string")
     */
    protected $iban;

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
     * @return string
     */
    public function getFianceConsultId(): string
    {
        return $this->fianceConsultId;
    }

    /**
     * @param string $fianceConsultId
     *
     * @return Customer
     */
    public function setFianceConsultId(string $fianceConsultId): Customer
    {
        $this->fianceConsultId = $fianceConsultId;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Customer
     */
    public function setEmail(string $email): Customer
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return Customer
     */
    public function setFirstName(string $firstName): Customer
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return Customer
     */
    public function setLastName(string $lastName): Customer
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCompany(): ?string
    {
        return $this->company;
    }

    /**
     * @param string $company
     *
     * @return Customer
     */
    public function setCompany(string $company): Customer
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string $street
     *
     * @return Customer
     */
    public function setStreet(string $street): Customer
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getHouseNumber(): ?string
    {
        return $this->houseNumber;
    }

    /**
     * @param string $houseNumber
     *
     * @return Customer
     */
    public function setHouseNumber(string $houseNumber): Customer
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     *
     * @return Customer
     */
    public function setZipCode(string $zipCode): Customer
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     *
     * @return Customer
     */
    public function setCity(string $city): Customer
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getIban(): ?string
    {
        return $this->iban;
    }

    /**
     * @param string $iban
     *
     * @return Customer
     */
    public function setIban(string $iban): Customer
    {
        $this->iban = $iban;

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
    public function setContracts(array $contracts): Customer
    {
        $this->contracts = $contracts;

        return $this;
    }

    /**
     * @param Contract $contract
     *
     * @return Customer
     */
    public function addContract(Contract $contract): Customer
    {
        $this->contracts[] = $contract;

        return $this;
    }

    /**
     * @param Contract $contract
     *
     * @return Customer
     */
    public function removeContract(Contract $contract): Customer
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
    public function setDocuments(array $documents): Customer
    {
        $this->documents = $documents;

        return $this;
    }

    /**
     * @param Document $contract
     *
     * @return Customer
     */
    public function addDocument(Document $contract): Customer
    {
        $this->documents[] = $contract;

        return $this;
    }

    /**
     * @param Document $contract
     *
     * @return Customer
     */
    public function removeDocument(Document $contract): Customer
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
