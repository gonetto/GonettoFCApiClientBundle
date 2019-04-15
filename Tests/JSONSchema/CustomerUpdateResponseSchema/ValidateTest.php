<?php

namespace Gonetto\FCApiClientBundle\Tests\JSONSchema\CustomerUpdateResponseSchema;

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

    /** {@inheritDoc} */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->schemaFile = (object)['$ref' => 'file://'.__DIR__.'/../../../JSONSchema/CustomerUpdateResponseSchema.json'];
    }

    /**
     * @dataProvider jsonsProvider
     *
     * @param string $json
     * @param string|null $message
     * @param bool $assert
     */
    public function testValidation(string $json, string $message = null, bool $assert = true): void
    {
        // Create new instance for test
        $exampleResponse = json_decode($json, false);

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
            'successful' => ['{"result":true}', 'example response is valid'],
            'wrong status key' => ['{"success":true}', 'example response is valid', false],
            'error' => ['{"result":false, "error":"test"}', 'example response is valid'],
            'error without message' => ['{"result":false}', 'example response is valid'],
            'invalid json' => ['', 'null is invalid.', false],
            'invalid empty object' => ['{}', 'empty object {} is invalid.', false],
        ];
    }
}
