<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\ResponseMapper;

use Gonetto\FCApiClientBundle\Model\Contract;
use Gonetto\FCApiClientBundle\Model\Customer;
use Gonetto\FCApiClientBundle\Service\ResponseMapper;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class MapTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Service\ResponseMapper
 */
class MapTest extends WebTestCase
{

    /** @var ResponseMapper */
    protected $responseMapper;

    /** @var array of Customers with Contracts */
    protected $customers;

    /**
     * {@inheritDoc}
     *
     * @throws \Exception
     */
    protected function setUp()
    {
        $this->responseMapper = new ResponseMapper();

        $this->loadDataFixtures();
    }

    /**
     * Test map() customers with addresses and contacts.
     *
     * @throws \Exception
     */
    public function testMapCustomers()
    {
        // Deserialize JSON with JMS Serializer
        $json = file_get_contents(__DIR__.'/FinanceConsultApiResponse.json');
        $customers = $this->responseMapper->map($json);

        // Compare result
        $this->assertEquals($this->customers, $customers);
    }

    /**
     * @throws \Exception
     */
    protected function loadDataFixtures()
    {
        $this->customers = [
          (new Customer())
            ->setFianceConsultId('RD1PP')
            ->setEmail('max.mustermann@web.de')
            ->setFirstName('Max')
            ->setLastName('Mustermann')
            ->setCompany('Musterfirma')
            ->setStreet('Musterstr. 1')
            ->setZipCode(12345)
            ->setCity('Musterstadt')
            ->setIban('DE02120300000000202051')
            ->setContracts(
              [
                (new Contract())
                  ->setFianceConsultId('RD1PN')
                  ->setFee(82.23)
                  ->setInsurer('Allianz Versicherungs-AG')
                  ->setGonettoContractNumber(345)
                  ->setMainRenewalDate(new \DateTime('2017-08-01'))
                  ->setInsuranceType('Unfall')
                  ->setContractDate(new \DateTime('2018-06-15T11:47:49'))
                  ->setEndOfContract(new \DateTime('2019-08-01'))
                  ->setFinanceConsultContractNumber('4864516/213')
                  ->setContractNumber('4864516/213')
                  ->setPaymentInterval(12),
              ]
            )
        ];
    }
}
