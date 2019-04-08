<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\DataClient\GetFile;

use Gonetto\FCApiClientBundle\Model\Document;
use Gonetto\FCApiClientBundle\Model\FileResponse;
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
 * Class GetFileTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Service\DataClient\GetFile
 */
class GetFileTest extends KernelTestCase
{

    /** @var \Gonetto\FCApiClientBundle\Service\DataClient */
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
     */
    protected function mockGuzzleClient()
    {
        // Api response
        $json = file_get_contents(__DIR__.'/ApiFileResponse.json');

        // Mock client
        $mock = new MockHandler([new Response(200, [], $json)]);
        $handler = HandlerStack::create($mock);
        $guzzleClient = new Client(['handler' => $handler]);

        // Pass mocked api client to data client
        $this->dataClient = new DataClient(
            '',
            $guzzleClient,
            (new CustomerUpdateRequestFactory())->createResponse(),
            (new DataRequestFactory())->createResponse(),
            (new FileRequestFactory())->createResponse(),
            (new JmsSerializerFactory())->createSerializer()
        );
    }

    /**
     * @test
     *
     * @throws \Exception
     */
    public function testResponse()
    {
        // Request file
        $document = (new Document())
            ->setFianceConsultId('1B5O3V')
            ->setContractId('19DB5Y');
        $fileResponse = $this->dataClient->getFile($document);

        // Check response
        $this->assertInstanceOf(FileResponse::class, $fileResponse);
    }
}
