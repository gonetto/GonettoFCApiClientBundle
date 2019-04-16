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
    protected $financeConsultId;

    /**
     * @var string
     *
     * @JMS\Type("string")
     */
    protected $email;

    /**
     * var string
     *
     * JMS\Type("string")
     * JMS\SerializedName("anrede")
     *
     * @ignore
     * @todo implements sync from FC to gonetto. Current only update at FC defined.
     *
     * @example planned: male,female,company,person // convert with EventSubscriber to number
     * @example values: 1=Herr,2=Frau,3=Firma,4=Person
     */
    protected $gender;

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
     * var string
     *
     * JMS\Type("string")
     * JMS\SerializedName("geburtsdatum")
     *
     * //yyyy-MM-dd
     *
     * @ignore
     * @todo implements sync from FC to gonetto. Current only update at FC defined.
     */
    protected $birthday;

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
     * var string
     *
     * JMS\Type("string")
     * JMS\SerializedName("fax")
     *
     * @ignore
     * @todo implements sync from FC to gonetto. Current only update at FC defined.
     */
    protected $fax;

    /**
     * var string
     *
     * JMS\Type("string")
     * JMS\SerializedName("telefon")
     *
     * @ignore
     * @todo implements sync from FC to gonetto. Current only update at FC defined.
     */
    protected $phone;

    /**
     * var string
     *
     * JMS\Type("string")
     * JMS\SerializedName("kontoinhaber")
     *
     * @ignore
     * @todo implements sync from FC to gonetto. Current only update at FC defined.
     */
    protected $depositor;

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
     * @JMS\SkipWhenEmpty
     */
    protected $contracts = [];

    /**
     * @param \Gonetto\FCApiClientBundle\Model\Customer $customer
     *
     * @return $this
     */
    public function clone(Customer $customer): self
    {
        foreach (get_object_vars($customer) as $key => $value) {
            $this->$key = $value;
        }

        return $this;
    }

    /**
     * @return string
     *
     * @deprecated
     * @see Customer::getFinanceConsultId()
     */
    public function getFianceConsultId(): ?string
    {
        return $this->financeConsultId;
    }

    /**
     * @return string
     */
    public function getFinanceConsultId(): ?string
    {
        return $this->financeConsultId;
    }

    /**
     * @param string $financeConsultId
     *
     * @return Customer
     *
     * @deprecated
     * @see Customer::setFinanceConsultId()
     */
    public function setFianceConsultId(string $financeConsultId): self
    {
        $this->financeConsultId = $financeConsultId;

        return $this;
    }

    /**
     * @param string $financeConsultId
     *
     * @return Customer
     */
    public function setFinanceConsultId(string $financeConsultId): self
    {
        $this->financeConsultId = $financeConsultId;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Customer
     */
    public function setEmail(string $email): self
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
    public function setFirstName(string $firstName): self
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
    public function setLastName(string $lastName): self
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
    public function setCompany(string $company): self
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
    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return null|string
     *
     * @deprecated
     */
    public function getHouseNumber(): ?string
    {
        return '';
    }

    /**
     * @param string $houseNumber
     *
     * @return Customer
     *
     * @deprecated
     */
    public function setHouseNumber(string $houseNumber): self
    {
        $this->street .= $houseNumber;

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
    public function setZipCode(string $zipCode): self
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
    public function setCity(string $city): self
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
    public function setIban(string $iban): self
    {
        $this->iban = $iban;

        return $this;
    }

    /**
     * @return array
     *
     * @deprecated
     */
    public function getContracts(): array
    {
        return $this->contracts;
    }

    /**
     * @param array $contracts
     *
     * @return Customer
     *
     * @deprecated
     */
    public function setContracts(array $contracts): self
    {
        $this->contracts = $contracts;

        return $this;
    }

    /**
     * @param Contract $contract
     *
     * @return Customer
     *
     * @deprecated
     */
    public function addContract(Contract $contract): self
    {
        $this->contracts[] = $contract;

        return $this;
    }

    /**
     * @param Contract $contract
     *
     * @return Customer
     *
     * @deprecated
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
}
