<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\ResponseMapper;

use Gonetto\FCApiClientBundle\Model\Customer;
use Gonetto\FCApiClientBundle\Model\DataResponse;
use Gonetto\FCApiClientBundle\Service\ResponseMapper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class MapTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Service\ResponseMapper
 */
class MapTest extends KernelTestCase
{

    /** @var ResponseMapper */
    protected $responseMapper;

    /** @var \Gonetto\FCApiClientBundle\Model\DataResponse */
    protected $data;

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
    public function testMapCustomers()
    {
        // Deserialize JSON with JMS Serializer
        $json = file_get_contents(__DIR__.'/ApiDataResponse.json');
        $dataResponse = $this->responseMapper->map($json);

        // Compare result
        $this->assertEquals($this->data, $dataResponse);
    }

    /**
     * @throws \Exception
     */
    protected function loadDataFixtures()
    {
        $this->data = (new DataResponse())
            ->addCustomer(
                (new Customer())
                    ->setFianceConsultId('RD1PP')
                    ->setEmail('max.mustermann@domain.tld')
            );
    }
}
