<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\DataClient;

use Gonetto\FCApiClientBundle\Model\DataResponse;
use Gonetto\FCApiClientBundle\Service\ApiClient;
use Gonetto\FCApiClientBundle\Service\DataClient;
use Gonetto\FCApiClientBundle\Service\DataRequestFactory;
use Gonetto\FCApiClientBundle\Service\FileRequestFactory;
use Gonetto\FCApiClientBundle\Service\JmsSerializerFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class GetAllSinceTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Service\DataClient
 */
class DeprecatedGetAllTest extends KernelTestCase
{

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
    }

    /**
     * Setup client for mock.
     */
    protected function mockApiClient()
    {
        // Api response
        $json = file_get_contents(__DIR__.'/DeprecatedApiDataResponse.json');

        // Mock client
        $apiClient = $this->createMock(ApiClient::class);
        $apiClient->method('send')->willReturn($json);

        // Pass mocked api client to customer client
        $this->dataClient = new DataClient(
            $apiClient,
            (new DataRequestFactory())->createResponse(),
            (new FileRequestFactory())->createResponse(),
            (new JmsSerializerFactory())->createSerializer()
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

        // Check customer
        $this->assertInstanceOf(DataResponse::class, $dataResponse);
        $this->assertCount(1, $dataResponse->getCustomers());

        // Check contract – test refactored structure
        $this->assertCount(0, $dataResponse->getCustomers()[0]->getContracts());
        $this->assertCount(1, $dataResponse->getContracts());
    }
}
