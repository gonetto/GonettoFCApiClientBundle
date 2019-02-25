<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\Serializer\Minimum;

use Gonetto\FCApiClientBundle\Model\DataResponse;
use Gonetto\FCApiClientBundle\Service\JmsSerializerFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class DeprecatedDeserializePaymentIntervalTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Service\Serializer\Minimum
 */
class DeprecatedDeserializePaymentIntervalTest extends KernelTestCase
{

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
    }

    /**
     * Test map() customers with addresses and contacts.
     *
     * @throws \Exception
     */
    public function testDeserialize()
    {
        $this->assertEquals(12, $this->deserialize('{"kunden":[{"verträge":[{"zahlungsweise":"monatlich"}]}]}'));
        $this->assertEquals(4, $this->deserialize('{"kunden":[{"verträge":[{"zahlungsweise":"vierteljahrlich"}]}]}'));
        $this->assertEquals(2, $this->deserialize('{"kunden":[{"verträge":[{"zahlungsweise":"halbjährlich"}]}]}'));
        $this->assertEquals(1, $this->deserialize('{"kunden":[{"verträge":[{"zahlungsweise":"jahrlich"}]}]}'));
        $this->assertEquals(0, $this->deserialize('{"kunden":[{"verträge":[{"zahlungsweise":"einmalig"}]}]}'));
    }

    public function testDeserializeUnknownInterval()
    {
        $this->assertEquals(0, $this->deserialize('{"kunden":[{"verträge":[{"zahlungsweise":"unbekannt"}]}]}'));
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
        /** @var \Gonetto\FCApiClientBundle\Model\Customer $customer */
        $customer = $dataResponse->getCustomers()[0];
        /** @var \Gonetto\FCApiClientBundle\Model\Contract $contract */
        $contract = $customer->getContracts()[0];

        return $contract->getPaymentInterval();
    }
}
