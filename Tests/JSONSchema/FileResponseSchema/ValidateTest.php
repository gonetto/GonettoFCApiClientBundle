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
     */
    public function testNoResponse(): void
    {
        $exampleResponse = null;

        // Check validator result
        $validator = new Validator();
        $validator->validate($exampleResponse, $this->schemaFile);
        $this->assertFalse($validator->isValid(), 'null is invalid.');
    }

    /**
     * @test
     */
    public function testEmptyResponse(): void
    {
        $exampleResponse = new \stdClass;

        // Check validator result
        $validator = new Validator();
        $validator->validate($exampleResponse, $this->schemaFile);
        $this->assertFalse($validator->isValid(), 'Empty object is invalid.');
    }

    /**
     * @test
     * @dataProvider parametersProvider
     *
     * @param string $parameter
     * @param bool $assert
     */
    public function testMissingParameter(string $parameter, bool $assert = false): void
    {
        // Create new instance for test
        $exampleResponse = json_decode($this->exampleResponse);

        // Unset parameter
        unset($exampleResponse->$parameter);

        // Check validator result
        $validator = new Validator();
        $validator->validate($exampleResponse, $this->schemaFile);
        if ($assert === false) {
            $this->assertFalse($validator->isValid(), "Missing parameter '$parameter' is invalid.");
        } else {
            $this->assertTrue($validator->isValid(), "Missing parameter '$parameter' is valid.");
        }
    }

    /**
     * @return array
     */
    public function parametersProvider(): array
    {
        return [
            'erstelltAm' => ['erstelltAm'],
            'data' => ['data'],
            'extension' => ['extension'],
        ];
    }
}
