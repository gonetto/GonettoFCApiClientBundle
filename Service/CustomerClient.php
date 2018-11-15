<?php

namespace Gonetto\FCApiClientBundle\Service;

use GuzzleHttp\Client;

/**
 * Class CustomerClient
 *
 * @package Gonetto\FCApiClientBundle\Client
 */
class CustomerClient
{

    /** @var string */
    protected $financeConsultApiAccessToken;

    /** @var string */
    protected $financeConsultApiPath;

    /** @var Client */
    protected $client;

    /** @var JSONSchemaCheck */
    protected $jsonSchemaCheck;

    /** @var ResponseMapper */
    protected $responseMapper;

    /**
     * RESTAPIClient constructor.
     *
     * @param string $financeConsultApiAccessToken
     * @param string $financeConsultApiPath
     * @param Client $client
     * @param JSONSchemaCheck $jsonSchemaCheck
     * @param ResponseMapper $responseMapper
     */
    public function __construct(
      string $financeConsultApiAccessToken,
      string $financeConsultApiPath,
      Client $client,
      JSONSchemaCheck $jsonSchemaCheck,
      ResponseMapper $responseMapper
    ) {
        $this->financeConsultApiAccessToken = $financeConsultApiAccessToken;
        $this->financeConsultApiPath = $financeConsultApiPath;
        $this->client = $client;
        $this->jsonSchemaCheck = $jsonSchemaCheck;
        $this->responseMapper = $responseMapper;
    }

    /**
     * Get all customers from Finance Consult API
     *
     * @return mixed
     * @throws \Exception
     */
    public function getAll(): array
    {
        return $this->getAllSince();
    }

    /**
     * Get all customers from Finance Consult API since specific date
     *
     * @param \DateTime|null $since
     *
     * @return mixed
     * @throws \Exception
     */
    public function getAllSince(\DateTime $since = null): array
    {
        // Get data from api
        $content = $this->requestJsonFromFCApi($since);

        throw new \Exception('$content: '.$content);

        // Check response
        $valid = $this->jsonSchemaCheck->check(json_decode($content), __DIR__.'/../JSONSchema/CustomersSchema.json');

        echo PHP_EOL;
        var_dump('$valid: '.$valid);
        echo PHP_EOL;

        // Check if valid response
        if (!$valid) {
            throw new \Exception(
              'Finance Consult API dosen\'t sent valid JSON schema. Contact fc support or update the schema.'
            );
        }

        var_dump($content);
        echo PHP_EOL;

        // Map response to object list
        $customers = $this->responseMapper->map($content, 'customers');

        var_dump($customers);
        echo PHP_EOL;

        return $customers[0];
    }

    /**
     * @param \DateTime|null $since
     *
     * @return string
     * @throws \Exception
     */
    public function requestJsonFromFCApi(\DateTime $since = null): string
    {
        $date = $since ? $since->format('Y-m-d\TH:i:s.v\Z') : '';

        // Get all Finance Consult customer
        $response = $this->client->get(
          $this->financeConsultApiPath,
          ['body' => '{"token":"'.$this->financeConsultApiAccessToken.'","since":"'.$date.'"}']
        );
        $content = (string)$response->getBody();

        // Check if valid JSON response
        if (json_decode($content) === null) {
            throw new \Exception('Finance Consult API dosen\'t sent valid JSON. Check API Token or the response.');
        }

        return $content;
    }
}
