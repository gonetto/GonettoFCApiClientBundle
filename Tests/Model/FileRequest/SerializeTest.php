<?php

namespace Gonetto\FCApiClientBundle\Tests\Model\FileRequest;

use Gonetto\FCApiClientBundle\Model\FileRequest;
use Gonetto\FCApiClientBundle\Factory\JmsSerializerFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class SerializeTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Model\FileRequest
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
     * @throws \Exception
     */
    public function testRequestAll(): void
    {
        // Serialize object
        $request = (new FileRequest())
            ->setToken('8029fdd175474c61909ca5f0803965bb464ff546')
            ->setDocumentId('1B5O3V')
            ->setContractId('19DB5Y');
        $jsonRequest = $this->serializer->serialize($request, 'json');

        // Check result
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/FileRequest.json', $jsonRequest);
    }
}
