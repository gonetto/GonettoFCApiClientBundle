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
        $this->exampleResponse = file_get_contents(__DIR__.'/DeprecatedApiDataResponse.json');
    }

    /**
     * @return \stdClass
     */
    protected function getExampleResponse(): \stdClass
    {
        return json_decode($this->exampleResponse);
    }

    public function testValidResponse(): void
    {
        $exampleResponse = $this->getExampleResponse();

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
        $exampleResponse = $this->getExampleResponse();
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
