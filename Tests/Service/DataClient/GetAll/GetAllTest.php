<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\DataClient\GetAll;

use Gonetto\FCApiClientBundle\Model\DataResponse;
use Gonetto\FCApiClientBundle\Service\ApiClient;
use Gonetto\FCApiClientBundle\Service\DataClient;
use Gonetto\FCApiClientBundle\Service\DataRequestFactory;
use Gonetto\FCApiClientBundle\Service\FileRequestFactory;
use Gonetto\FCApiClientBundle\Service\JmsSerializerFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class GetAllTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Service\DataClient\GetAll
 */
class GetAllTest extends KernelTestCase
{

    /** @var DataClient */
    protected $dataClient;

    /** @var array */
    protected $dispatchedFileRequest;

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
        $apiClient->method('send')
            ->will(
                $this->returnCallback(
                    function ($parameter) use ($json) {
                        // Note api request
                        $this->dispatchedFileRequest = $parameter;

                        // Return api response
                        return $json;
                    }
                )
            );

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
    public function testRequest()
    {
        // Make request
        $this->dataClient->getAll();

        // Check request json
        $this->assertArrayHasKey('body', $this->dispatchedFileRequest);
        $this->assertJson($this->dispatchedFileRequest['body']);
    }

    /**
     * Test map() customers with addresses and contacts.
     *
     * @throws \Exception
     */
    public function testResponse()
    {
        // Deserialize JSON with JMS Serializer
        $dataResponse = $this->dataClient->getAll();

        // Check customer
        $this->assertInstanceOf(DataResponse::class, $dataResponse);
        $this->assertCount(1, $dataResponse->getCustomers());
    }
}
