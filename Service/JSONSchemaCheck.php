<?php

namespace Gonetto\FCApiClientBundle\Service;

use JsonSchema\Validator;
use Symfony\Component\Filesystem\Filesystem;

// TODO:GN:MS: Entweder eigenes compser package draus machen oder entfernen, weil dies auch in der Bestandsübertragung genutzt wird.

/**
 * Class JSONSchemaCheck
 *
 * @package Gonetto\FCApiClientBundle
 */
class JSONSchemaCheck
{

    /** @var string */
    protected $folder = __DIR__.'../JSONSchema/';

    /** @var string */
    protected $file;

    /** @var \Symfony\Component\Filesystem\Filesystem */
    protected $fs;

    /** @var \JsonSchema\Validator */
    protected $validator;

    /**
     * BrokerageCalculator constructor.
     */
    public function __construct()
    {
        $this->fs = new Filesystem();
        $this->validator = new Validator;
    }

    /**
     * Check array by JSON Schema
     *
     * @param array $contracts
     * @param string $schema
     *
     * @return bool
     * @throws \Exception
     */
    public function check($contracts, $schema = '')
    {
        // Set file
        if (strpos($schema, '.json') !== false) {
            $this->setFile($schema);
        } elseif ($schema) {
            $this->setFile($this->folder.$schema.'.json');
        }

        // Check readability
        $this->checkFileReadability();

        // Check JSON Data by JSON Schema
        $this->validator->validate($contracts, (object)['$ref' => 'file://'.$this->file]);

        return $this->validator->isValid();
    }

    /**
     * Check array by JSON Schema
     *
     * @param string $schema_name
     *
     * @return array|mixed
     * @throws \Exception
     */
    public function getSchema($schema_name = '')
    {
        // Set file
        if ($schema_name) {
            $this->setFile($this->folder.$schema_name.'.json');
        }

        // Check readability
        $this->checkFileReadability();

        // Get JSON Schema
        $schema = json_decode(file_get_contents($this->file), true);

        // Include relation schemas
        $schema = $this->addRelationSchema($schema);

        return $schema;
    }

    /**
     * Combine schemas with $ref recursive
     *
     * @param array $schema
     *
     * @return array
     */
    protected function addRelationSchema($schema)
    {
        foreach ($schema as $key => $s) {
            // Recursion case
            if ($key !== '$ref' && is_array($s)) {
                $schema[$key] = $this->addRelationSchema($s);
            }

            // Include case
            if ($key === '$ref' && is_string($s)) {
                // Remove relation information
                unset($schema[$key]);

                // Replace with relation schema
                $schema = json_decode(file_get_contents($this->folder.$s), true);

                // Include more relation schemas (twice recursion case)
                $schema = $this->addRelationSchema($schema);

                // Remove duplicate schema information
                unset($schema['$schema']);
            }
        }

        // Recursion break condition
        return $schema;
    }

    /**
     * Set full filename with path
     *
     * @param string $file
     *
     * @return JSONSchemaCheck
     */
    public function setFile(string $file): JSONSchemaCheck
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Check JSONSchema file readability
     *
     * @return bool
     * @throws \Exception
     */
    protected function checkFileReadability()
    {
        if (!$this->fs->exists($this->file)) {
            throw new \Exception('JSONSchema file "'.$this->file.'" is not readable');
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function getErrors()
    {
        return $this->validator->getErrors();
    }
}

