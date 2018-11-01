<?php

namespace Tests\Gonetto\FCApiClientBundle\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ResponseMapperTest
 *
 * @package Tests\Gonetto\FCApiClientBundle\Service
 */
class ResponseMapperTest extends WebTestCase
{

    /** @var \Gonetto\FCApiClientBundle\Service\ResponseMapper */
    protected $responseMapper;

    /** {@inheritDoc} */
    protected function setUp()
    {
        self::bootKernel();
        $this->responseMapper = static::$kernel->getContainer()->get(
            'test_alias.app.finance_consult.service.response_mapper'
        );
    }

    /**
     * Test map() customers with addresses and contacts.
     */
    public function testMapCustomers()
    {
        $this->traversingObject(
            $this->responseMapper->map(
                file_get_contents(__DIR__.'/Customers/FinanceConsultApiResponse.json'),
                'customers'
            ),
            (new Yaml())::parse(file_get_contents(__DIR__.'/Customers/ClassSchema.yml'))
        );
    }

    /**
     * Check class by schema
     *
     * @param $object
     * @param $schema
     * @param string $error_path
     */
    protected function traversingObject($object, $schema, $error_path = '')
    {
        $error_message = 'Failed at ';

        // Recursion case one.
        if ($schema['type'] === 'array') {
            // Check if array
            $this->assertInternalType('array', $object, $error_message.$error_path);
            if (!is_array($object)) {
                return;
            }

            foreach ($object as $key => $ob) {
                // Recursion
                $list[] = $this->traversingObject($ob, $schema['items'][$key], $error_path.'['.$key.']');
            }

            return;
        }

        // Traversing object methods
        if ($schema['type'] === 'object') {
            // Check if object
            $this->assertEquals('object', gettype($object), $error_message.$error_path);
            if (gettype($object) !== 'object') {
                return;
            }

            // Check correct class
            $this->assertEquals($schema['class'], get_class($object), $error_message.$error_path);
            if (get_class($object) !== $schema['class']) {
                return;
            }
            $error_path .= '('.$schema['class'].')';

            // Check class values
            foreach ($schema['properties'] as $method => $schemaParameters) {
                $value = $object->$method();
                $error_method = '->'.$method.'()';
                switch ($schemaParameters['type']) {
                    case 'array':
                        // Recursion case two.
                        $this->traversingObject($value, $schemaParameters, $error_path.$error_method);
                        break;
                    case 'int':
                        $this->assertEquals(
                            $schemaParameters['value'],
                            $value,
                            $error_message.$error_path.$error_method
                        );
                        break;
                    case 'double':
                    case 'float':
                        $this->assertEquals(
                            $schemaParameters['value'],
                            $value,
                            $error_message.$error_path.$error_method
                        );
                        break;
                    case 'string':
                        $this->assertEquals(
                            $schemaParameters['value'],
                            $value,
                            $error_message.$error_path.$error_method
                        );
                        break;
                    case 'boolean':
                        $this->assertEquals(
                            $schemaParameters['value'],
                            $value,
                            $error_message.$error_path.$error_method
                        );
                        break;
                    case 'date':
                        $date_string = $schemaParameters['value'];
                        if (empty($date_string) || !is_string($date_string) || $date_string === '0000-00-00') {
                            $this->assertNull($value, $error_message.$error_path.$error_method);
                        } else {
                            $this->assertEquals(
                                new \DateTime($schemaParameters['value']),
                                $value,
                                $error_message.$error_path.$error_method
                            );
                        }
                        break;
                    case 'entity':
                        // Check if object
                        $this->assertEquals('object', gettype($value), $error_message.$error_path.$error_method);
                        if (gettype($value) !== 'object') {
                            break;
                        }

                        // Check correct entity
                        $this->assertEquals(
                            $schemaParameters['entity'],
                            get_class($value),
                            $error_message.$error_path.$error_method
                        );
                        if (get_class($value) !== $schemaParameters['entity']) {
                            break;
                        }

                        // Check value of entity
                        $entityMethod = $schemaParameters['method'];
                        $this->assertEquals(
                            $schemaParameters['method_value'],
                            $value->$entityMethod(),
                            $error_message.$error_path.$error_method
                        );
                        break;
                }
            }

            return;
        }
    }
}
