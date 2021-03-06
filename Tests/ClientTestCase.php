<?php

namespace Gonetto\FCApiClientBundle\Tests;

use Gonetto\FCApiClientBundle\Factory\CustomerUpdateRequestFactory;
use Gonetto\FCApiClientBundle\Factory\DataRequestFactory;
use Gonetto\FCApiClientBundle\Factory\FileRequestFactory;
use Gonetto\FCApiClientBundle\Factory\JmsSerializerFactory;
use Gonetto\FCApiClientBundle\Service\DataClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ClientTestCase extends KernelTestCase
{

    /**
     * @param string $api_json_response
     *
     * @return \Gonetto\FCApiClientBundle\Service\DataClient
     * @throws \Exception
     */
    protected function mockGuzzleClientInDataClient(string $api_json_response): DataClient
    {
        // Pass mocked api client to data client
        $dataClient = new DataClient(
            '',
            $this->mockGuzzleClient($api_json_response),
            (new CustomerUpdateRequestFactory('dummy'))->createRequest(),
            (new DataRequestFactory('dummy'))->createRequest(),
            (new FileRequestFactory('dummy'))->createRequest(),
            (new JmsSerializerFactory())->createSerializer()
        );

        return $dataClient;
    }

    private function mockGuzzleClient(string $api_json_response): Client
    {
        $mock = new MockHandler([new Response(200, [], $api_json_response)]);
        $handler = HandlerStack::create($mock);

        return new Client(['handler' => $handler]);
    }
}
