<?php

namespace Gonetto\FCApiClientBundle\Service;

use Symfony\Component\Yaml\Yaml;

class ResponseMapper
{

    /**
     * @param string $response
     * @param string $map
     *
     * @return mixed
     * @throws \Exception
     */
    public function map(string $response, string $map)
    {
        // Decode response
        $customersResponse = json_decode($response, true);

        // Get map
        $map = (new Yaml())::parse(file_get_contents(__DIR__.'/../Map/'.$map.'.yml'));

        return $this->traversingMap($customersResponse, $map);
    }

    /**
     * @param array $customersResponse
     * @param array $map
     *
     * @return array|mixed
     * @throws \Exception
     */
    protected function traversingMap(array $customersResponse, array $map)
    {
        // Recursion case zero. Not mapped array of objects.
        if ($map['type'] === 'nullObject') {
            $list = [];
            foreach ($map['properties'] as $parameters) {
                // Check if parameter exists
                if (!array_key_exists($parameters['property'], $customersResponse)) {
                    throw new \Exception(
                        'Property with key "'.$parameters['property'].'" not found in: '
                        .substr(print_r($customersResponse, true), 0, 500).'…'
                    );
                }

                $list[] = $this->traversingMap($customersResponse[$parameters['property']], $parameters['item']);
            }

            return $list;
        }

        // Recursion case one. Array of objects.
        if ($map['type'] === 'array') {
            $list = [];
            foreach ($customersResponse as $response) {
                $list[] = $this->traversingMap($response, $map['items']);
            }

            return $list;
        }

        // Create object
        if ($map['type'] === 'object') {
            // Create object
            $tempClass = new $map['class'];

            // Set class values
            foreach ($map['properties'] as $method => $parameters) {
                // Get set method
                $setMethod = 'set'.ucfirst($method);

                // Check if parameter exists
                if (!array_key_exists($parameters['property'], $customersResponse)) {
                    throw new \Exception(
                        'Property with key "'.$parameters['property'].'" not found in: '
                        .substr(print_r($customersResponse, true), 0, 500).'…'
                    );
                }

                // Get value
                switch ($parameters['type']) {
                    case 'array':
                        // Recursion case two. Object with array list.
                        $value = [];
                        if (isset($customersResponse[$parameters['property']])) {
                            foreach ($customersResponse[$parameters['property']] as $response) {
                                $value[] = $this->traversingMap($response, $parameters['items']);
                            }
                        }
                        break;
                    case 'string':
                        $value = trim(strval($customersResponse[$parameters['property']]));
                        break;
                    case 'int':
                        $value = intval($customersResponse[$parameters['property']]);
                        break;
                    case 'double':
                    case 'float':
                        $value = doubleval($customersResponse[$parameters['property']]);
                        break;
                    case 'boolean':
                        $value = boolval($customersResponse[$parameters['property']]);
                        break;
                    case 'enum':
                        $value = strval($customersResponse[$parameters['property']]);
                        // Set only correct values
                        if (!in_array($value, $parameters['properties'])) {
                            $value = '';
                        }
                        break;
                    case 'date':
                        $date_string = $customersResponse[$parameters['property']];
                        // Prevent wrong date
                        if (empty($date_string) || !is_string($date_string) || $date_string === '0000-00-00') {
                            $value = null;
                        } else {
                            $value = new \DateTime($date_string);
                        }
                        break;
                    case 'datetime':
                        $date_string = $customersResponse[$parameters['property']];
                        // Prevent wrong date
                        if (empty($date_string) || !is_string($date_string) || $date_string === '0000-00-00T00:00:00') {
                            $value = null;
                        } else {
                            $value = new \DateTime($date_string);
                        }
                        break;
                    default:
                        $value = null;
                }

                // Set class value
                $tempClass->$setMethod($value);
            }

            return $tempClass;
        }

        // Case array of integers
        if ($map['type'] === 'int') {
            return intval($customersResponse[$map['property']]);
        }

        // Recursion case three. Linked map.
        if ($map['type'] === 'rel') {
            return $this->map(json_encode($customersResponse), $map['target']);
        }
    }
}

