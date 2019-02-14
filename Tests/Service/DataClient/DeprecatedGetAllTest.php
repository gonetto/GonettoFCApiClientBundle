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
                    ->setFianceConsultId('RD1PN')
                    ->setCustomerId('RD1PP')
                    ->setFee(82.23)
                    ->setInsurer('Allianz Versicherungs-AG')
                    ->setGonettoContractNumber(345)
                    ->setMainRenewalDate(new \DateTime('2017-08-01'))
                    ->setInsuranceType('Unfall')
                    ->setContractDate(new \DateTime('2018-06-15T11:47:49'))
                    ->setEndOfContract(new \DateTime('2019-08-01'))
                    ->setContractNumber('4864516/213')
                    ->setPaymentInterval(12)
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
