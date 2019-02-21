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

    /**
     * {@inheritDoc}
     *
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->schemaFile = (object)['$ref' => 'file://'.__DIR__.'/../../../JSONSchema/DataResponseSchema.json'];
    }

    /**
     * @return \stdClass
     */
    protected function exampleResponse(): \stdClass
    {
        return (object)[
            'kunden' => [
                (object)[
                    'oid' => '19P1CF',
                    'email' => 'anna.musterfrau@domain.tld',
                    'vorname' => 'Anna',
                    'nachname' => 'Musterfrau',
                    'firma' => 'Beispielfirma',
                    'strasse' => 'Beispielstr. 2',
                    'plz' => '54321',
                    'ort' => 'Beispielstadt',
                    'iban' => 'DE02500105170137075030',
                ],
            ],
            'kundenDeleted' => [
                '1B6PS1',
            ],
            'vertraege' => [
                (object)[
                    'oid' => 'SB1CK',
                    'kundeID' => '19P1CF',
                    'beitrag' => 656.9,
                    'gesellschaft' => 'DEVK Versicherungen',
                    'hauptfälligkeit' => '2006-04-01T00:00:00',
                    'produkt' => 'Wohngebäude',
                    'vermittlungsdatum' => '2018-03-27T11:21:37',
                    'vertragsende' => '2019-04-01T00:00:00',
                    'vertragsnummer' => '2397868001',
                    'zahlungsweise' => 'jahrlich',
                ],
            ],
            'vertraegeDeleted' => [
                'AB45U',
            ],
            'dokumente' => [
                (object)[
                    'oid' => '1B5O3V',
                    'vertragID' => '19DB5Y',
                    'art' => 2,
                    'datum' => '2019-02-04T13:26:58',
                ],
            ],
            'dokumenteDeleted' => [
                '19CTC5',
            ],
        ];
    }

    public function testValidResponse(): void
    {
        $exampleResponse = $this->exampleResponse();

        $validator = new Validator();
        $validator->validate($exampleResponse, $this->schemaFile);
        $this->assertTrue($validator->isValid(), print_r($validator->getErrors(), true));
    }

    public function testNoResponse(): void
    {
        $exampleResponse = null;

        $validator = new Validator();
        $validator->validate($exampleResponse, $this->schemaFile);
        $this->assertFalse($validator->isValid(), 'null is not valid.');
    }

    public function testEmptyResponse(): void
    {
        $exampleResponse = (object)[];

        $validator = new Validator();
        $validator->validate($exampleResponse, $this->schemaFile);
        $this->assertTrue($validator->isValid(), 'Empty array [] is valid.');
    }

    public function testEmptyCategories(): void
    {
        $this->emptyCategoryTest('kunden');
        $this->emptyCategoryTest('kundenDeleted');
        $this->emptyCategoryTest('vertraege');
        $this->emptyCategoryTest('vertraegeDeleted');
        $this->emptyCategoryTest('dokumente');
        $this->emptyCategoryTest('dokumenteDeleted');
    }

    /**
     * @param $category
     */
    protected function emptyCategoryTest($category): void
    {
        $exampleResponse = clone $this->exampleResponse();
        $exampleResponse->$category = [];

        $validator = new Validator();
        $validator->validate($exampleResponse, $this->schemaFile);
        $this->assertTrue($validator->isValid(), "Empty category '$category' is valid.");
    }

    public function testMissingParameters(): void
    {
        $this->missingParameterTest('kunden', 'oid');
        $this->missingParameterTest('kunden', 'email');
        $this->missingParameterTest('kunden', 'vorname');
        $this->missingParameterTest('kunden', 'nachname');
        $this->missingParameterTest('kunden', 'firma');
        $this->missingParameterTest('kunden', 'strasse');
        $this->missingParameterTest('kunden', 'plz');
        $this->missingParameterTest('kunden', 'ort');
        $this->missingParameterTest('kunden', 'iban');

        $this->missingParameterTest('vertraege', 'oid');
        $this->missingParameterTest('vertraege', 'kundeID', true);
        $this->missingParameterTest('vertraege', 'beitrag');
        $this->missingParameterTest('vertraege', 'gesellschaft');
        $this->missingParameterTest('vertraege', 'hauptfälligkeit');
        $this->missingParameterTest('vertraege', 'produkt');
        $this->missingParameterTest('vertraege', 'vermittlungsdatum');
        $this->missingParameterTest('vertraege', 'vertragsende');
        $this->missingParameterTest('vertraege', 'vertragsnummer');
        $this->missingParameterTest('vertraege', 'zahlungsweise');

        $this->missingParameterTest('dokumente', 'oid');
        $this->missingParameterTest('dokumente', 'vertragID');
        $this->missingParameterTest('dokumente', 'art');
        $this->missingParameterTest('dokumente', 'datum');
    }

    /**
     * @param string $category
     * @param string $parameter
     * @param bool $assert
     */
    protected function missingParameterTest(string $category, string $parameter, bool $assert = false): void
    {
        $exampleResponse = clone $this->exampleResponse();
        unset(($exampleResponse->$category)[0]->$parameter);

        $validator = new Validator();
        $validator->validate($exampleResponse, $this->schemaFile);

        if ($assert === false) {
            $this->assertFalse($validator->isValid(), "Missing parameter '$category/$parameter' is invalid.");
        } else {
            $this->assertTrue($validator->isValid(), "Missing parameter '$category/$parameter' is valid.");
        }
    }
}
