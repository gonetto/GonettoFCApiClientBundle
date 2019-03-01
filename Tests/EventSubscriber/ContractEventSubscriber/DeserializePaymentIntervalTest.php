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

    /**
     * @dataProvider paymentIntervalsProvider
     *
     * @param int $numeric
     * @param string $string
     */
    public function testDeprecatedDeserialize(int $numeric, string $string)
    {
        // Deserialize JSON
        $dataResponse = $this->deserialize('{"kunden":[{"verträge":[{"zahlungsweise":"'.$string.'"}]}]}');

        // Get contract
        $contract = $dataResponse->getCustomers()[0]->getContracts()[0];

        // Check payment interval
        $this->assertEquals($numeric, $contract->getPaymentInterval());
    }

    /**
     * @dataProvider paymentIntervalsProvider
     *
     * @param int $numeric
     * @param string $string
     */
    public function testDeserialize(int $numeric, string $string)
    {
        // Deserialize JSON
        $dataResponse = $this->deserialize('{"vertraege":[{"zahlungsweise":"'.$string.'"}]}');

        // Get contract
        $contract = $dataResponse->getContracts()[0];

        // Check payment interval
        $this->assertEquals($numeric, $contract->getPaymentInterval());
    }

    /**
     * @return array
     */
    public function paymentIntervalsProvider()
    {
        return [
            'monatlich' => [12, 'monatlich'],
            'vierteljahrlich' => [4, 'vierteljahrlich'],
            'vierteljaehrlich' => [4, 'vierteljaehrlich'],
            'vierteljährlich' => [4, 'vierteljährlich'],
            'halbjahrlich' => [2, 'halbjahrlich'],
            'halbjaehrlich' => [2, 'halbjaehrlich'],
            'halbjährlich' => [2, 'halbjährlich'],
            'jahrlich' => [1, 'jahrlich'],
            'jaehrlich' => [1, 'jaehrlich'],
            'jährlich' => [1, 'jährlich'],
            'einmalig' => [0, 'einmalig'],
            'unbekannt' => [0, 'unbekannt'],
        ];
    }

    /**
     * @param string $json
     *
     * @return \Gonetto\FCApiClientBundle\Model\DataResponse
     */
    protected function deserialize(string $json): DataResponse
    {
        return $this->serializer->deserialize($json, DataResponse::class, 'json');
    }
}
