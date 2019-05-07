<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\DataClient\UpdateCustomer;

use Faker\Factory;
use Gonetto\FCApiClientBundle\Model\Customer;
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
    }

    /**
     * Setup client for mock.
     *
     * @param string $result
     *
     * @throws \Exception
     */
    protected function mockGuzzleClient(string $result): void
    {
        // Mock client
        $mock = new MockHandler([new Response(200, [], $result)]);
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
     * @throws \Exception
     */
    public function testResponse(): void
    {
        // Mock result
        $this->mockGuzzleClient('{"result": true}');

        // Request file
        $customer = (new Customer())
            ->setFinanceConsultId('RD1PN')
            ->setIban($this->faker->iban());
        $updateResponse = $this->dataClient->updateCustomer($customer);

        // Check response
        $this->assertTrue($updateResponse->isSuccess());
        $this->assertNull($updateResponse->getErrorMessage());
    }

    /**
     * @throws \Exception
     */
    public function testMissingFinanceConsultId(): void
    {
        // Mock result
        $this->mockGuzzleClient('{"result": true}');

        // Request file
        $customer = (new Customer())
            ->setStreet($this->faker->streetAddress)
            ->setCity($this->faker->city)
            ->setZipCode($this->faker->postcode);
        $updateResponse = $this->dataClient->updateCustomer($customer);

        // Check response
        $this->assertFalse($updateResponse->isSuccess());
        $this->assertSame('The finance consult id is needed.', $updateResponse->getErrorMessage());
    }

    /**
     * @throws \Exception
     */
    public function testWrongFinanceConsultId(): void
    {
        // Mock result
        $this->mockGuzzleClient('{"error":"OID ungültig oder keine Berechtigung","result":false}');

        // Request file
        $customer = (new Customer())
            ->setFinanceConsultId('RD1PN')
            ->setIban($this->faker->iban());
        $updateResponse = $this->dataClient->updateCustomer($customer);

        // Check response
        $this->assertFalse($updateResponse->isSuccess());
        $this->assertSame('OID ungültig oder keine Berechtigung', $updateResponse->getErrorMessage());
    }
}
