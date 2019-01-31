<?php

namespace Gonetto\FCApiClientBundle\Service;

use GuzzleHttp\Client;

/**
 * Class ApiClient
 *
 * @package Gonetto\FCApiClientBundle\Service
 */
class ApiClient
{

    /** @var Client */
    protected $client;

    /** @var string */
    protected $financeConsultApiPath;

    /**
     * RESTAPIClient constructor.
     *
     * @param string $financeConsultApiPath
     * @param Client $client
     */
    public function __construct(string $financeConsultApiPath, Client $client)
    {
        $this->financeConsultApiPath = $financeConsultApiPath;
        $this->client = $client;
    }

    /**
     * @param array $options
     *
     * @return string
     * @throws \Exception
     */
    public function send($options = []): string
    {
        // Get all Finance Consult customer
        $stream = $this->client->get($this->financeConsultApiPath, $options);
        $response = (string)$stream->getBody();

        // Check if valid JSON response
        if (json_decode($response) === null) {
            throw new \Exception(
                'Finance Consult API dosen\'t sent valid JSON. Check the response.'
                .' (Response: "'.$response.'")'
            );
        }

        return $response;
    }
}
