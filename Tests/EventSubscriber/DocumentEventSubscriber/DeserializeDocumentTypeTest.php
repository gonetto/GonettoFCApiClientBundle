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

    /**
     * @dataProvider documentTypesProvider
     *
     * @param string|int $string
     * @param int $numeric
     */
    public function testDeserialize($string, int $numeric): void
    {
        // Deserialize JSON
        $json = '{"dokumente":[{"art":'.$numeric.'}]}';
        $dataResponse = $this->serializer->deserialize($json, DataResponse::class, 'json');

        // Get document
        /** @var \Gonetto\FCApiClientBundle\Model\Document $document */
        $document = $dataResponse->getDocuments()[0];

        $this->assertSame($string, $document->getType());
    }

    /**
     * @return array
     */
    public function documentTypesProvider(): array
    {
        return [
            'known type' => ['Antrag', 2],
            'unknown type between' => [46, 46],
            'last known type' => ['Vertragsrücktritt', 51],
            'unknown type' => [52, 52],
        ];
    }
}
