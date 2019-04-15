<?php

namespace Gonetto\FCApiClientBundle\Tests\Model\DataRequest;

use DateTime;
use Gonetto\FCApiClientBundle\Model\DataRequest;
use Gonetto\FCApiClientBundle\Service\JmsSerializerFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class GetAllTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Service\DataClient\GetAll
 */
class SerializeTest extends KernelTestCase
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
     * @test
     *
     * @throws \Exception
     */
    public function testRequestAll()
    {
        // Serialize object
        $dataRequest = (new DataRequest())
            ->setToken('8029fdd175474c61909ca5f0803965bb464ff546');
        $jsonRequest = $this->serializer->serialize($dataRequest, 'json');

        // Check result
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/DataRequestAll.json', $jsonRequest);
    }

    /**
     * Test map() customers with addresses and contacts.
     *
     * @test
     *
     * @throws \Exception
     */
    public function testRequestAllSince()
    {
        // Serialize object
        $dataRequest = (new DataRequest())
            ->setToken('8029fdd175474c61909ca5f0803965bb464ff546')
            ->setSinceDate(new DateTime('2019-02-15'));
        $jsonRequest = $this->serializer->serialize($dataRequest, 'json');

        // Check result
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/DataRequestAllSince.json', $jsonRequest);
    }
}
