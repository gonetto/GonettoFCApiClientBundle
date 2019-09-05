<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\DataClient\UpdateCustomer;

use Faker\Factory;
use Gonetto\FCApiClientBundle\Model\Customer;
use Gonetto\FCApiClientBundle\Tests\ClientTestCase;

/**
 * Class UpdateCustomerTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Service\DataClient\UpdateCustomer
 */
class UpdateCustomerTest extends ClientTestCase
{

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
     * @throws \Exception
     */
    public function testResponse(): void
    {
        // Mock result
        $dataClient = $this->mockGuzzleClientInDataClient('{"result": true}');

        // Request file
        $customer = (new Customer())
            ->setFinanceConsultId('RD1PN')
            ->setIban($this->faker->iban());
        $updateResponse = $dataClient->updateCustomer($customer);

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
        $dataClient = $this->mockGuzzleClientInDataClient('{"result": true}');

        // Request file
        $customer = (new Customer())
            ->setStreet($this->faker->streetAddress)
            ->setCity($this->faker->city)
            ->setZipCode($this->faker->postcode);
        $updateResponse = $dataClient->updateCustomer($customer);

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
        $dataClient = $this->mockGuzzleClientInDataClient(
            '{"error":"OID ungültig oder keine Berechtigung","result":false}'
        );

        // Request file
        $customer = (new Customer())
            ->setFinanceConsultId('RD1PN')
            ->setIban($this->faker->iban());
        $updateResponse = $dataClient->updateCustomer($customer);

        // Check response
        $this->assertFalse($updateResponse->isSuccess());
        $this->assertSame('OID ungültig oder keine Berechtigung', $updateResponse->getErrorMessage());
    }
}
