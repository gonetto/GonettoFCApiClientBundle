<?php

namespace Gonetto\FCApiClientBundle\Tests\JSONSchema\FileResponseSchema;

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
        $this->schemaFile = (object)['$ref' => 'file://'.__DIR__.'/../../../JSONSchema/FileResponseSchema.json'];
        $this->exampleResponse = file_get_contents(__DIR__.'/ApiFileResponse.json');
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

    public function testNoResponse(): void
    {
        $exampleResponse = null;

        $validator = new Validator();
        $validator->validate($exampleResponse, $this->schemaFile);
        $this->assertFalse($validator->isValid(), 'null is invalid.');
    }

    public function testEmptyResponse(): void
    {
        $exampleResponse = new \stdClass;

        $validator = new Validator();
        $validator->validate($exampleResponse, $this->schemaFile);
        $this->assertFalse($validator->isValid(), 'Empty object is invalid.');
    }

    public function testMissingParameters(): void
    {
        $this->missingParameterTest('erstelltAm');
        $this->missingParameterTest('data');
        $this->missingParameterTest('extension');
    }

    /**
     * @param string $parameter
     * @param bool $assert
     */
    protected function missingParameterTest(string $parameter, bool $assert = false): void
    {
        $exampleResponse = clone $this->getExampleResponse();
        unset($exampleResponse->$parameter);

        $validator = new Validator();
        $validator->validate($exampleResponse, $this->schemaFile);
        if ($assert === false) {
            $this->assertFalse($validator->isValid(), "Missing parameter '$parameter' is invalid.");
        } else {
            $this->assertTrue($validator->isValid(), "Missing parameter '$parameter' is valid.");
        }
    }
}
