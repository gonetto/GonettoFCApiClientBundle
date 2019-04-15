<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\DataClient\GetFile;

Use Exception;
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

    /**
     * Guzzle for mock.
     *
     * @param $statusCode
     * @param string $body
     *
     * @return \Gonetto\FCApiClientBundle\Service\DataClient
     * @throws \Exception
     */
    protected function mockGuzzleClient($statusCode = 200, $body = ''): DataClient
    {
        // Set default api response
        if (empty($body)) {
            $body = file_get_contents(__DIR__.'/ApiFileResponse.json');
        }

        // Mock client
        $mock = new MockHandler([new Response($statusCode, [], $body)]);
        $handler = HandlerStack::create($mock);
        $guzzleClient = new Client(['handler' => $handler]);

        // Pass mocked api client to data client
        return new DataClient(
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
    public function testGetFile(): void
    {
        // Request file
        $document = (new Document())
            ->setFianceConsultId('1B5O3V')
            ->setContractId('19DB5Y');
        $fileResponse = $this->mockGuzzleClient()->getFile($document);

        // Check response
        $this->assertInstanceOf(FileResponse::class, $fileResponse);
    }

    /**
     * @dataProvider parametersProvider
     *
     * @param \Gonetto\FCApiClientBundle\Model\Document $document
     *
     * @throws \Exception
     */
    public function testMissingParameters(Document $document): void
    {
        $this->expectException(Exception::class);
        $this->mockGuzzleClient()->getFile($document);
    }

    /**
     * @return array
     */
    public function parametersProvider(): array
    {
        return [
            'FinanceConsultId missing' => [
                (new Document())
                    ->setFianceConsultId('')
                    ->setContractId('19DB5Y'),
            ],
            'ContractId missing' => [
                (new Document())
                    ->setFianceConsultId('1B5O3V')
                    ->setContractId(''),
            ],
        ];
    }

    /**
     * Test error message at getFile()
     *
     * @throws \Exception
     */
    public function testInvalidId(): void
    {

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('check the submitted Fiance Consult ID');

        $dataClient = $this->mockGuzzleClient(200, '{"result":false}');
        $dataClient->getFile(
            (new Document())
                ->setFianceConsultId('wrongId')
                ->setContractId('wrongId')
        );
    }
}
