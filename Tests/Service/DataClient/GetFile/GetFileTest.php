<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\DataClient\GetFile;

use Gonetto\FCApiClientBundle\Model\Document;
use Gonetto\FCApiClientBundle\Model\FileResponse;
use Gonetto\FCApiClientBundle\Service\ApiClient;
use Gonetto\FCApiClientBundle\Service\DataClient;
use Gonetto\FCApiClientBundle\Service\DataRequestFactory;
use Gonetto\FCApiClientBundle\Service\FileRequestFactory;
use Gonetto\FCApiClientBundle\Service\JmsSerializerFactory;
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
        $json = file_get_contents(__DIR__.'/ApiFileResponse.json');

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
        // Request file
        $document = (new Document())
            ->setFianceConsultId('1B5O3V')
            ->setContractId('19DB5Y');
        $this->dataClient->getFile($document);

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
        // TODO:GN:MS: test aufräumen, serializieren wird schonn in models geprüft

        // Request file
        $document = (new Document())
            ->setFianceConsultId('1B5O3V')
            ->setContractId('19DB5Y');
        $fileResponse = $this->dataClient->getFile($document);

        // Check response
        $this->assertInstanceOf(FileResponse::class, $fileResponse);
    }
}
