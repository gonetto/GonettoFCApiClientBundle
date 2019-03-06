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
     * ValidateTest constructor.
     *
     * @param string|null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->exampleResponse = file_get_contents(__DIR__.'/ApiFileResponse.json');
    }

    /**
     * {@inheritDoc}
     *
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->schemaFile = (object)['$ref' => 'file://'.__DIR__.'/../../../JSONSchema/FileResponseSchema.json'];
    }

    /**
     * @test
     * @dataProvider jsonsProvider
     *
     * @param string $json
     * @param string|null $message
     * @param bool $assert
     */
    public function testValidResponse(string $json, string $message = null, bool $assert = true): void
    {
        // Create new instance for test
        $exampleResponse = json_decode($json);

        // Check validator result
        $validator = new Validator();
        $validator->validate($exampleResponse, $this->schemaFile);
        $message .= $assert === true ? ' '.print_r($validator->getErrors(), true) : '';
        $this->assertSame($assert, $validator->isValid(), $message);
    }

    /**
     * @return array
     */
    public function jsonsProvider(): array
    {
        return [
            'valid json response' => [$this->exampleResponse, 'example response is valid'],
            'invalid json' => ['', 'null is invalid.', false],
            'empty object' => ['{}', 'empty object {} is invalid.', false],
        ];
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
