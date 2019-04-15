<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\DataClient\UpdateCustomer;

use Faker\Factory;
use Gonetto\FCApiClientBundle\Model\Customer;
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

    /** @var \Faker\Generator */
    protected $faker;

    /**
     * {@inheritDoc}
     *
     * @throws \Exception
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->faker = Factory::create('de_DE');

        $this->mockGuzzleClient();
    }

    /**
     * Setup client for mock.
     *
     * @throws \Exception
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
            (new CustomerUpdateRequestFactory('dummy'))->createRequest(),
            (new DataRequestFactory('dummy'))->createRequest(),
            (new FileRequestFactory('dummy'))->createRequest(),
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
            ->setIban($this->faker->iban());
        $updateResponse = $this->dataClient->updateCustomer($customer);

        // Check response
        $this->assertInstanceOf(CustomerUpdateResponse::class, $updateResponse);
        $this->assertTrue($updateResponse->isSuccess());
        $this->assertNull($updateResponse->getErrorMessage());
    }

    /**
     * @test
     *
     * @throws \Exception
     */
    public function testMissingFinanceConsultId()
    {
        // Request file
        $customer = (new Customer())
            ->setStreet($this->faker->streetAddress)
            ->setCity($this->faker->city)
            ->setZipCode($this->faker->postcode);
        $updateResponse = $this->dataClient->updateCustomer($customer);

        // Check response
        $this->assertInstanceOf(CustomerUpdateResponse::class, $updateResponse);
        $this->assertFalse($updateResponse->isSuccess());
        $this->assertSame('The finance consult id is needed.', $updateResponse->getErrorMessage());
    }
}
