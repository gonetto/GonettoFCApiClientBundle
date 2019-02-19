<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\Serializer\Minimum;

use Gonetto\FCApiClientBundle\Model\Contract;
use Gonetto\FCApiClientBundle\Model\DataResponse;
use Gonetto\FCApiClientBundle\Service\JmsSerializerFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class DeserializePaymentIntervalTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Service\Serializer\Minimum
 */
class DeserializePaymentIntervalTest extends KernelTestCase
{

    /** @var \Gonetto\FCApiClientBundle\Model\DataResponse */
    protected $data;

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
    public function testMapCustomers()
    {
        // Deserialize JSON
        $jsonResponse = file_get_contents(__DIR__.'/ApiDataResponse.json');
        $dataResponse = $this->serializer->deserialize($jsonResponse, DataResponse::class, 'json');

        // Compare result
        $this->assertEquals($this->data, $dataResponse);
    }

    /**
     * @throws \Exception
     */
    protected function loadDataFixtures()
    {
        $this->data = (new DataResponse())
            ->setContracts(
                [
                    (new Contract())->setPaymentInterval(12),
                    (new Contract())->setPaymentInterval(4),
                    (new Contract())->setPaymentInterval(2),
                    (new Contract())->setPaymentInterval(1),
                    (new Contract())->setPaymentInterval(0),
                ]
            );
    }
}
