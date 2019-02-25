<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\Serializer\Minimum;

use Gonetto\FCApiClientBundle\Model\DataResponse;
use Gonetto\FCApiClientBundle\Service\JmsSerializerFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class DeserializeDocumentTypeTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Service\Serializer\Minimum
 */
class DeserializeDocumentTypeTest extends KernelTestCase
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
        $this->assertEquals('Antrag', $this->deserialize('{"dokumente":[{"art":2}]}'));
    }

    public function testDeserializeUnknownType()
    {
        $this->assertEquals(46, $this->deserialize('{"dokumente":[{"art":46}]}'));
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

        // Get document
        /** @var \Gonetto\FCApiClientBundle\Model\Document $document */
        $document = $dataResponse->getDocuments()[0];

        return $document->getType();
    }
}
