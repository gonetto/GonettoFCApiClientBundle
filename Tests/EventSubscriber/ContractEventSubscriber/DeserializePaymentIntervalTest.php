<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\Serializer\Minimum;

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

    /** @var \JMS\Serializer\Serializer */
    protected $serializer;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->serializer = (new JmsSerializerFactory())->createSerializer();
    }

    public function testDeserialize()
    {
        $this->assertEquals(12, $this->deserialize('{"vertraege":[{"zahlungsweise":"monatlich"}]}'));
        $this->assertEquals(4, $this->deserialize('{"vertraege":[{"zahlungsweise":"vierteljahrlich"}]}'));
        $this->assertEquals(2, $this->deserialize('{"vertraege":[{"zahlungsweise":"halbjährlich"}]}'));
        $this->assertEquals(1, $this->deserialize('{"vertraege":[{"zahlungsweise":"jahrlich"}]}'));
        $this->assertEquals(0, $this->deserialize('{"vertraege":[{"zahlungsweise":"einmalig"}]}'));
    }

    public function testDeserializeUnknownInterval()
    {
        $this->assertEquals(0, $this->deserialize('{"vertraege":[{"zahlungsweise":"unbekannt"}]}'));
    }

    /**
     * @param string $json
     *
     * @return mixed
     */
    protected function deserialize(string $json)
    {
        // Deserialize JSON
        /** @var DataResponse $dataResponse */
        $dataResponse = $this->serializer->deserialize($json, DataResponse::class, 'json');

        // Get contract
        /** @var \Gonetto\FCApiClientBundle\Model\Contract $contract */
        $contract = $dataResponse->getContracts()[0];

        return $contract->getPaymentInterval();
    }
}
