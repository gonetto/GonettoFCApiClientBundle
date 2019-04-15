<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\DataClient;

use Gonetto\FCApiClientBundle\Model\DataResponse;
use Gonetto\FCApiClientBundle\Service\CustomerUpdateRequestFactory;
use Gonetto\FCApiClientBundle\Service\DataClient;
use Gonetto\FCApiClientBundle\Service\DataRequestFactory;
use Gonetto\FCApiClientBundle\Service\FileRequestFactory;
use Gonetto\FCApiClientBundle\Service\JmsSerializerFactory;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
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
        $this->mockGuzzleClient();
    }

    /**
     * Setup client for mock.
     *
     * @throws \Exception
     */
    protected function mockGuzzleClient(): void
    {
        // Api response
        $json = file_get_contents(__DIR__.'/DeprecatedApiDataResponse.json');

        // Mock client
        $mock = new MockHandler([new Response(200, [], $json)]);
        $handler = HandlerStack::create($mock);
        $guzzleClient = new Client(['handler' => $handler]);

        // Pass mocked api client to customer client
        $this->dataClient = new DataClient(
            '',
            $guzzleClient,
            (new CustomerUpdateRequestFactory('dummy'))->createRequest(),
            (new DataRequestFactory('dummy'))->createRequest(),
            (new FileRequestFactory('dummy'))->createRequest(),
            (new JmsSerializerFactory())->createSerializer()
        );
    }

    /**
     * @throws \Exception
     */
    public function testGetAllSince(): void
    {
        // Deserialize JSON with JMS Serializer
        $dataResponse = $this->dataClient->getAll();

        // Check customer
        $this->assertInstanceOf(DataResponse::class, $dataResponse);
        $this->assertCount(1, $dataResponse->getCustomers());

        // Check contract – test refactored structure
        /** @var \Gonetto\FCApiClientBundle\Model\Customer $customer */
        $customer = $dataResponse->getCustomers()[0];
        $this->assertCount(0, $customer->getContracts());
        $this->assertCount(1, $dataResponse->getContracts());
    }
}
