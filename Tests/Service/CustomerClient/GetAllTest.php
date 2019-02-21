<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\CustomerClient;

use Gonetto\FCApiClientBundle\Service\ApiClient;
use Gonetto\FCApiClientBundle\Service\CustomerClient;
use Gonetto\FCApiClientBundle\Service\JmsSerializerFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class GetAllSinceTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Service\CustomerClient
 */
class GetAllTest extends KernelTestCase
{

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
    }

    /**
     * Setup client for mock.
     */
    protected function mockApiClient()
    {
        // Api response
        $json = file_get_contents(__DIR__.'/ApiDataResponse.json');

        // Mock client
        $apiClient = $this->createMock(ApiClient::class);
        $apiClient->method('send')->willReturn($json);

        // Pass mocked api client to customer client
        $serializer = (new JmsSerializerFactory())->createSerializer();
        $this->customerClient = new CustomerClient('', $apiClient, $serializer);
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

        // Check customers
        $this->assertCount(2, $customers);

        // Check contract 1
        $this->assertObjectHasAttribute('contracts', $customers[0]);
        $this->assertCount(1, $customers[0]->getContracts());

        // Check contract 2
        $this->assertObjectHasAttribute('contracts', $customers[1]);
        $this->assertCount(1, $customers[1]->getContracts());
    }
}
