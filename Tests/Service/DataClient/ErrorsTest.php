<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\DataClient;

use Gonetto\FCApiClientBundle\Service\DataClient;
use Gonetto\FCApiClientBundle\Service\DataRequestFactory;
use Gonetto\FCApiClientBundle\Service\FileRequestFactory;
use Gonetto\FCApiClientBundle\Service\JmsSerializerFactory;
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
    public function testForbidden()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(403);

        $dataClient = $this->mockGuzzleClient(403);
        $dataClient->getAll();
    }

    /**
     * @test
     *
     * @throws \Exception
     */
    public function testNotFound()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(404);

        $dataClient = $this->mockGuzzleClient(404);
        $dataClient->getAll();
    }

    /**
     * @test
     *
     * @throws \Exception
     */
    public function testInvalidToken()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Finance Consult API dosen\'t sent valid JSON. Check the response');

        $dataClient = $this->mockGuzzleClient(200, 'Ungültiges Token (php)');
        $dataClient->getAll();
    }
}
