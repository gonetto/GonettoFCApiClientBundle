<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\CustomerClient;

use Gonetto\FCApiClientBundle\Model\Customer;
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
                ->setFianceConsultId('19P1CF')
                ->setEmail('anna.musterfrau@domain.tld')
                ->setFirstName('Anna')
                ->setLastName('Musterfrau')
                ->setCompany('Beispielfirma')
                ->setStreet('Beispielstr. 2')
                ->setZipCode(54321)
                ->setCity('Beispielstadt')
                ->setIban('DE02500105170137075030')
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
