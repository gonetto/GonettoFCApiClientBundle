<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\ResponseMapper;

use Gonetto\FCApiClientBundle\Model\Customer;
use Gonetto\FCApiClientBundle\Service\ResponseMapper;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class DeprecatedMapTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Service\ResponseMapper
 */
class DeprecatedMapTest extends WebTestCase
{

    /** @var ResponseMapper */
    protected $responseMapper;

    /** @var array of Customers with Contracts */
    protected $customers;

    /**
     * {@inheritDoc}
     *
     * @throws \Exception
     */
    protected function setUp()
    {
        $this->responseMapper = new ResponseMapper();

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
        $json = file_get_contents(__DIR__.'/ApiDataResponse.json');
        $dataResponse = $this->responseMapper->map($json);
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
