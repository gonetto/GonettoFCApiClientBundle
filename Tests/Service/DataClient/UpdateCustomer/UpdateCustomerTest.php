<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\DataClient\UpdateCustomer;

use Gonetto\FCApiClientBundle\Model\Customer;
use Gonetto\FCApiClientBundle\Model\CustomerUpdateRequest;
use Gonetto\FCApiClientBundle\Model\CustomerUpdateResponse;
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
 * Class UpdateCustomerTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Service\DataClient\UpdateCustomer
 */
class UpdateCustomerTest extends KernelTestCase
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
        parent::setUp();

        // Mock api client
        $this->mockGuzzleClient();
    }

    /**
     * Setup client for mock.
     */
    protected function mockGuzzleClient()
    {
        // Mock client
        $mock = new MockHandler([new Response(200, [], '{"result": true}')]);
        $handler = HandlerStack::create($mock);
        $guzzleClient = new Client(['handler' => $handler]);

        // Pass mocked api client to data client
        $this->dataClient = new DataClient(
            '',
            $guzzleClient,
            (new CustomerUpdateRequestFactory('803...'))->createResponse(),
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
        $customer = (new Customer())
            ->setFianceConsultId('DE02500105170137075030')
            ->setIban('19DB5Y');
        $updateResponse = $this->dataClient->updateCustomer($customer);

        // TODO:GN:MS: FC ID ist erzwungen! testen

        // Check response
        $this->assertInstanceOf(CustomerUpdateResponse::class, $updateResponse);
        $this->assertTrue($updateResponse->isSuccess());
        $this->assertNull($updateResponse->getErrorMessage());
    }
}
