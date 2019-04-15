<?php

namespace Gonetto\FCApiClientBundle\Tests\JSONSchema\DataResponseSchema;

use JsonSchema\Validator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class ValidateTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\JSONSchema\DataResponseSchema
 */
class ValidateTest extends KernelTestCase
{

    /** @var \stdClass Schema file reference */
    protected $schemaFile;

    /** @var \stdClass */
    protected $exampleResponse;

    /**
     * {@inheritDoc}
     *
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->schemaFile = (object)['$ref' => 'file://'.__DIR__.'/../../../JSONSchema/DataResponseSchema.json'];
        $this->exampleResponse = file_get_contents(__DIR__.'/ApiDataResponse.json');
    }

    public function testValidResponse(): void
    {
        // Create new instance for test
        $exampleResponse = json_decode($this->exampleResponse, false);

        // Check validator result
        $validator = new Validator();
        $validator->validate($exampleResponse, $this->schemaFile);
        $this->assertTrue($validator->isValid(), print_r($validator->getErrors(), true));
    }

    public function testNoResponse(): void
    {
        $exampleResponse = null;

        // Check validator result
        $validator = new Validator();
        $validator->validate($exampleResponse, $this->schemaFile);
        $this->assertFalse($validator->isValid(), 'null is not valid.');
    }

    public function testEmptyResponse(): void
    {
        $exampleResponse = (object)[];

        // Check validator result
        $validator = new Validator();
        $validator->validate($exampleResponse, $this->schemaFile);
        $this->assertTrue($validator->isValid(), 'Empty array [] is valid.');
    }

    /**
     * @dataProvider categoriesProvider
     *
     * @param $category
     */
    public function testEmptyCategory($category): void
    {
        // Create new instance for test
        $exampleResponse = json_decode($this->exampleResponse, false);

        // Unset category
        $exampleResponse->$category = [];

        // Check validator result
        $validator = new Validator();
        $validator->validate($exampleResponse, $this->schemaFile);
        $this->assertTrue($validator->isValid(), "Empty category '$category' is valid.");
    }

    /**
     * @return array
     */
    public function categoriesProvider(): array
    {
        return [
            'kunden' => ['kunden'],
            'kundenDeleted' => ['kundenDeleted'],
            'vertraege' => ['vertraege'],
            'vertraegeDeleted' => ['vertraegeDeleted'],
            'dokumente' => ['dokumente'],
            'dokumenteDeleted' => ['dokumenteDeleted'],
        ];
    }

    /**
     * @dataProvider parametersProvider
     *
     * @param string $category
     * @param string $parameter
     * @param bool $assert
     */
    public function testMissingParameter(string $category, string $parameter, bool $assert = false): void
    {
        // Create new instance for test
        $exampleResponse = json_decode($this->exampleResponse, false);

        // Unset parameter
        unset(($exampleResponse->$category)[0]->$parameter);

        // Check validator result
        $validator = new Validator();
        $validator->validate($exampleResponse, $this->schemaFile);
        if ($assert === false) {
            $this->assertFalse($validator->isValid(), "Missing parameter '$category/$parameter' is invalid.");
        } else {
            $this->assertTrue($validator->isValid(), "Missing parameter '$category/$parameter' is valid.");
        }
    }

    /**
     * @return array
     */
    public function parametersProvider(): array
    {
        return [
            'customer / oid' => ['kunden', 'oid'],
            'customer / email' => ['kunden', 'email'],
            'customer / vorname' => ['kunden', 'vorname'],
            'customer / nachname' => ['kunden', 'nachname'],
            'customer / firma' => ['kunden', 'firma'],
            'customer / strasse' => ['kunden', 'strasse'],
            'customer / plz' => ['kunden', 'plz'],
            'customer / ort' => ['kunden', 'ort'],
            'customer / iban' => ['kunden', 'iban'],
            'contract / oid' => ['vertraege', 'oid'],
            'contract / kundeID' => ['vertraege', 'kundeID', true],
            'contract / beitrag' => ['vertraege', 'beitrag'],
            'contract / gesellschaft' => ['vertraege', 'gesellschaft'],
            'contract / hauptfälligkeit' => ['vertraege', 'hauptfälligkeit'],
            'contract / produkt' => ['vertraege', 'produkt'],
            'contract / vermittlungsdatum' => ['vertraege', 'vermittlungsdatum'],
            'contract / vertragsende' => ['vertraege', 'vertragsende'],
            'contract / vertragsnummer' => ['vertraege', 'vertragsnummer'],
            'contract / zahlungsweise' => ['vertraege', 'zahlungsweise'],
            'document / oid' => ['dokumente', 'oid'],
            'document / vertragID' => ['dokumente', 'vertragID'],
            'document / art' => ['dokumente', 'art'],
            'document / datum' => ['dokumente', 'datum'],
        ];
    }
}
