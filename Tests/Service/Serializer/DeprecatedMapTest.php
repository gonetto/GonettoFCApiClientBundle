<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\Serializer;

use Gonetto\FCApiClientBundle\Model\Customer;
use Gonetto\FCApiClientBundle\Model\DataResponse;
use Gonetto\FCApiClientBundle\Service\JmsSerializerFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class DeprecatedMapTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Service\Serializer
 */
class DeprecatedMapTest extends KernelTestCase
{

    /** @var array of Customers with Contracts */
    protected $customers;

    /** @var \JMS\Serializer\Serializer */
    protected $serializer;

    /**
     * {@inheritDoc}
     *
     * @throws \Exception
     */
    protected function setUp()
    {
        $this->serializer = (new JmsSerializerFactory())->createSerializer();

        $this->loadDataFixtures();
    }

    /**
     * Test map() customers with addresses and contacts.
     *
     * @throws \Exception
     */
    public function testMap()
    {
        // Deserialize JSON with JMS Serializer
        $jsonResponse = file_get_contents(__DIR__.'/ApiDataResponse.json');
        $dataResponse = $this->serializer->deserialize($jsonResponse, DataResponse::class, 'json');
        $customers = $dataResponse->getCustomers();

        // Compare result
        $this->assertEquals($this->customers, $customers);
    }

    /**
     * @throws \Exception
     */
    protected function loadDataFixtures()
    {
        $this->customers = [
          (new Customer())
            ->setFianceConsultId('RD1PP')
            ->setEmail('max.mustermann@domain.tld')
        ];
    }
}
