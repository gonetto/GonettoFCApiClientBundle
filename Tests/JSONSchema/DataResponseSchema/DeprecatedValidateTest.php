<?php

namespace Gonetto\FCApiClientBundle\Tests\JSONSchema\DataResponseSchema;

use JsonSchema\Validator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class DeprecatedValidateTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\JSONSchema\DataResponseSchema
 */
class DeprecatedValidateTest extends KernelTestCase
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
     * @return object
     */
    protected function exampleResponse(): \stdClass
    {
        return (object)[
            "kunden" => [
                (object)[
                    "oid" => "19P1CF",
                    "email" => "anna.musterfrau@domain.tld",
                    "vorname" => "Anna",
                    "nachname" => "Musterfrau",
                    "firma" => "Beispielfirma",
                    "strasse" => "Beispielstr. 2",
                    "plz" => "54321",
                    "ort" => "Beispielstadt",
                    "iban" => "DE02500105170137075030",
                    "vertraege" => [
                        (object)[
                            "oid" => "SB1CK",
                            "beitrag" => 656.9,
                            "gesellschaft" => "DEVK Versicherungen",
                            "gonetto-id" => "345",
                            "hauptfälligkeit" => "2006-04-01T00:00:00",
                            "produkt" => "Wohngebäude",
                            "vermittlungsdatum" => "2018-03-27T11:21:37",
                            "vertragsende" => "2019-04-01T00:00:00",
                            "vertragsnummer" => "2397868001",
                            "zahlungsweise" => "jahrlich",
                        ],
                    ],
                ],
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
        $this->missingParameterTest('kunden', 'vertraege', true);
    }

    /**
     * @param string $category
     * @param string $parameter
     * @param bool $assert
     */
    protected function missingParameterTest(string $category, string $parameter, bool $assert = false): void
    {
        $exampleResponse = $this->exampleResponse();
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
