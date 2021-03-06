<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\DataClient;

use Exception;
use Gonetto\FCApiClientBundle\Factory\CustomerUpdateRequestFactory;
use Gonetto\FCApiClientBundle\Factory\DataRequestFactory;
use Gonetto\FCApiClientBundle\Factory\FileRequestFactory;
use Gonetto\FCApiClientBundle\Factory\JmsSerializerFactory;
use Gonetto\FCApiClientBundle\Service\DataClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class GetFileTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Service\DataClient\GetFile
 */
class ErrorsTest extends KernelTestCase
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
    protected function mockGuzzleClient($statusCode, $body = ''): DataClient
    {
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
    public function testForbidden(): void
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(403);

        $dataClient = $this->mockGuzzleClient(403);
        $dataClient->getAll();
    }

    /**
     * @throws \Exception
     */
    public function testNotFound(): void
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(404);

        $dataClient = $this->mockGuzzleClient(404);
        $dataClient->getAll();
    }

    /**
     * @throws \Exception
     */
    public function testInvalidToken(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Finance Consult API dosen\'t sent valid JSON. Check the response');

        $dataClient = $this->mockGuzzleClient(200, 'Ungültiges Token (php)');
        $dataClient->getAll();
    }
}
