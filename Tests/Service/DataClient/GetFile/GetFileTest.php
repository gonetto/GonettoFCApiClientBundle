<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\DataClient;

use Gonetto\FCApiClientBundle\Model\Document;
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
class GetFileTest extends KernelTestCase
{

    /** @var ApiClient|\PHPUnit_Framework_MockObject_MockObject */
    protected $apiClient;

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
        $this->apiClient = $this->createMock(ApiClient::class);
        $this->apiClient->method('send')
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
            $this->apiClient,
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

        // Compare request
        $this->assertArrayHasKey('body', $this->dispatchedFileRequest);
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/ApiFileRequest.json', $this->dispatchedFileRequest['body']);
    }

    /**
     * Test map() customers with addresses and contacts.
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

        // Compare result
        $this->assertEquals(2, $fileResponse->getDocumentType());
        $this->assertEquals('2019-01-14', $fileResponse->getCreated()->format('Y-m-d'));
        $this->assertEquals(base64_encode(file_get_contents(__DIR__.'/ApiFileResponse.pdf')), $fileResponse->getFile());
        $this->assertEquals('pdf', $fileResponse->getExtension());
    }
}
