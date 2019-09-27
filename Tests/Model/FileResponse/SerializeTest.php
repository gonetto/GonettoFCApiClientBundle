<?php

namespace Gonetto\FCApiClientBundle\Tests\Model\FileResponse;

use Gonetto\FCApiClientBundle\Model\FileResponse;
use Gonetto\FCApiClientBundle\Factory\JmsSerializerFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class GetAllTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Service\DataClient\GetAll
 */
class SerializeTest extends KernelTestCase
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
    }

    /**
     * Test map() customers with addresses and contacts.
     *
     * @throws \Exception
     */
    public function testResponse(): void
    {
        // Deserialize JSON
        $jsonResponse = file_get_contents(__DIR__.'/FileResponse.json');
        /** @var FileResponse $fileResponse */
        $fileResponse = $this->serializer->deserialize($jsonResponse, FileResponse::class, 'json');

        // Compare result
        $this->assertEquals(base64_encode(file_get_contents(__DIR__.'/FileResponse.pdf')), $fileResponse->getFile());
        $this->assertEquals('pdf', $fileResponse->getExtension());
    }
}
