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
     * @test
     */
    public function testValidResponse(): void
    {
        // Create new instance for test
        $exampleResponse = json_decode($this->exampleResponse);

        // Check validator result
        $validator = new Validator();
        $validator->validate($exampleResponse, $this->schemaFile);
        $this->assertTrue($validator->isValid(), print_r($validator->getErrors(), true));
    }

    /**
     * @test
     * @dataProvider parametersProvider
     *
     * @param string $category
     * @param string $parameter
     * @param bool $allowed
     */
    public function testMissingParameter(string $category, string $parameter, bool $allowed = false): void
    {
        // Create new instance for test
        $exampleResponse = json_decode($this->exampleResponse);

        // Unset parameter
        unset(($exampleResponse->$category)[0]->$parameter);

        // Check validator result
        $validator = new Validator();
        $validator->validate($exampleResponse, $this->schemaFile);
        if ($allowed === false) {
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
            'customer / finance consult id' => ['kunden', 'oid'],
            'customer / email' => ['kunden', 'email'],
            'customer / first name' => ['kunden', 'vorname'],
            'customer / last name' => ['kunden', 'nachname'],
            'customer / company' => ['kunden', 'firma'],
            'customer / street' => ['kunden', 'strasse'],
            'customer / zip' => ['kunden', 'plz'],
            'customer / country' => ['kunden', 'ort'],
            'customer / iban' => ['kunden', 'iban'],
            'customer / contracts' => ['kunden', 'vertraege', true],
        ];
    }
}
