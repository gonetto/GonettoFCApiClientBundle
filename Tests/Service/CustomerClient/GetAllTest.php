<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\CustomerClient;

use Gonetto\FCApiClientBundle\Model\Contract;
use Gonetto\FCApiClientBundle\Model\Customer;
use Gonetto\FCApiClientBundle\Model\Document;
use Gonetto\FCApiClientBundle\Service\ApiClient;
use Gonetto\FCApiClientBundle\Service\CustomerClient;
use Gonetto\FCApiClientBundle\Service\ResponseMapper;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class GetAllSinceTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Service\CustomerClient
 */
class GetAllTest extends WebTestCase
{

    /** @var ApiClient|\PHPUnit_Framework_MockObject_MockObject */
    protected $apiClient;

    /** @var array of Customers with Contracts */
    protected $customers;

    /** @var CustomerClient */
    protected $customerClient;

    /**
     * {@inheritDoc}
     *
     * @throws \Exception
     */
    protected function setUp()
    {
        // Mock api client
        $this->mockApiClient();

        // Load result
        $this->loadDataFixtures();
    }

    /**
     * Setup client for mock.
     */
    protected function mockApiClient()
    {
        // Api response
        $json = file_get_contents(__DIR__.'/ApiDataResponse.json');

        // Mock client
        $this->apiClient = $this->createMock(ApiClient::class);
        $this->apiClient->method('send')->willReturn($json);

        // Pass mocked api client to customer client
        $this->customerClient = new CustomerClient('', $this->apiClient, new ResponseMapper());
    }

    /**
     * @throws \Exception
     */
    protected function loadDataFixtures()
    {
        $this->customers = [
            (new Customer())
                ->setFianceConsultId('RD1PP')
                ->setEmail('max.mustermann@domain.tld')
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

    /**
     * Test map() customers with addresses and contacts.
     *
     * @throws \Exception
     */
    public function testGetAllSince()
    {
        // Deserialize JSON with JMS Serializer
        $customers = $this->customerClient->getAll();

        // Compare result
        $this->assertEquals($this->customers, $customers);
    }
}
