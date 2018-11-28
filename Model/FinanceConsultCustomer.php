<?php

namespace Gonetto\FCApiClientBundle\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class FinanceConsultCustomer
 *
 * @package Gonetto\FCApiClientBundle\Model
 */
class FinanceConsultCustomer
{

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
     * @JMS\Type("array<Gonetto\FCApiClientBundle\Model\FinanceConsultContract>")
     * @JMS\SerializedName("verträge")
     */
    protected $contracts;

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
     * @return FinanceConsultCustomer
     */
    public function setEmail(string $email): FinanceConsultCustomer
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
     * @return FinanceConsultCustomer
     */
    public function setFirstName(string $firstName): FinanceConsultCustomer
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
     * @return FinanceConsultCustomer
     */
    public function setLastName(string $lastName): FinanceConsultCustomer
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
     * @return FinanceConsultCustomer
     */
    public function setCompany(string $company): FinanceConsultCustomer
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
     * @return FinanceConsultCustomer
     */
    public function setStreet(string $street): FinanceConsultCustomer
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
     * @return FinanceConsultCustomer
     */
    public function setHouseNumber(string $houseNumber): FinanceConsultCustomer
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
     * @return FinanceConsultCustomer
     */
    public function setZipCode(string $zipCode): FinanceConsultCustomer
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
     * @return FinanceConsultCustomer
     */
    public function setCity(string $city): FinanceConsultCustomer
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
     * @return FinanceConsultCustomer
     */
    public function setIban(string $iban): FinanceConsultCustomer
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
     * @return FinanceConsultCustomer
     */
    public function setContracts(array $contracts): FinanceConsultCustomer
    {
        $this->contracts = $contracts;

        return $this;
    }

    /**
     * @param FinanceConsultContract $contract
     *
     * @return FinanceConsultCustomer
     */
    public function addContract(FinanceConsultContract $contract): FinanceConsultCustomer
    {
        $this->contracts[] = $contract;

        return $this;
    }

    /**
     * @param FinanceConsultContract $contract
     *
     * @return FinanceConsultCustomer
     */
    public function removeContract(FinanceConsultContract $contract): FinanceConsultCustomer
    {
        foreach ($this->contracts as $key => $currentContract) {
            if ($contract->getContractNumber() === $currentContract->getContractNumber()) {
                unset($this->contracts[$key]);
                break;
            }
        }

        return $this;
    }
}
