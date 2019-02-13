<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\DataClient;

use Gonetto\FCApiClientBundle\Model\Contract;
use Gonetto\FCApiClientBundle\Model\Customer;
use Gonetto\FCApiClientBundle\Model\DataResponse;
use Gonetto\FCApiClientBundle\Service\ApiClient;
use Gonetto\FCApiClientBundle\Service\DataClient;
use Gonetto\FCApiClientBundle\Service\ResponseMapper;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class GetAllSinceTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Service\DataClient
 */
class DeprecatedGetAllTest extends WebTestCase
{

    /** @var ApiClient|\PHPUnit_Framework_MockObject_MockObject */
    protected $apiClient;

    /** @var DataResponse */
    protected $data;

    /** @var DataClient */
    protected $dataClient;

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
        $json = file_get_contents(__DIR__.'/DeprecatedApiDataResponse.json');

        // Mock client
        $this->apiClient = $this->createMock(ApiClient::class);
        $this->apiClient->method('send')->willReturn($json);

        // Pass mocked api client to customer client
        $this->dataClient = new DataClient('', $this->apiClient, new ResponseMapper());
    }

    /**
     * @throws \Exception
     */
    protected function loadDataFixtures()
    {
        $this->data = (new DataResponse())
            ->addCustomer(
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
            )
            ->addContract(
                (new Contract())
                    ->setFianceConsultId('SB1CK')
                    ->setFee(656.9)
                    ->setInsurer('DEVK Versicherungen')
                    ->setGonettoContractNumber(345)
                    ->setMainRenewalDate(new \DateTime('2006-04-01'))
                    ->setInsuranceType('Wohngebäude')
                    ->setContractDate(new \DateTime('2018-03-27T11:21:37'))
                    ->setEndOfContract(new \DateTime('2019-04-01'))
                    ->setContractNumber('2397868001')
                    ->setPaymentInterval(1)
            );
    }

    /**
     * Test map() customers with addresses and contacts.
     *
     * @throws \Exception
     */
    public function testGetAllSince()
    {
        // Deserialize JSON with JMS Serializer
        $dataResponse = $this->dataClient->getAll();

        // Compare result
        $this->assertEquals($this->data, $dataResponse);
    }
}
