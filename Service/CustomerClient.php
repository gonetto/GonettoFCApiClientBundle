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
        // TODO:GN:MS: sync so umbauen, das ich sicher prüfen kann ob alles funktioiert, aber ohne echten cal

        // Build api request
        $request = $this->createApiRequestContent($since);

        // Get json from api
        $jsonResponse = $this->requestToApi($request);

        // Check json
        $this->jsonSchemaCheck($jsonResponse);

        // Map json to object
        $customers = $this->responseMapper->map($jsonResponse);

        return $customers;
    }

    /**
     * @param \DateTime|null $since
     *
     * @return string
     */
    protected function createApiRequestContent(\DateTime $since = null): string
    {
        return json_encode(
          [
            'token' => $this->financeConsultApiAccessToken,
            'since' => $since ? $since->format('Y-m-d\TH:i:s.v\Z') : '',
          ]
        );
    }

    /**
     * @param string $request
     *
     * @return string
     * @throws \Exception
     */
    protected function requestToApi(string $request): string
    {
        // Get all Finance Consult customer
        $stream = $this->client->get($this->financeConsultApiPath, ['body' => $request]);
        $response = (string)$stream->getBody();

        // Check if valid JSON response
        if (json_decode($response) === null) {
            throw new \Exception('Finance Consult API dosen\'t sent valid JSON. Check API Token or the response.');
        }

        return $response;
    }

    /**
     * @param string $jsonResponse
     *
     * @throws \Exception
     */
    protected function jsonSchemaCheck(string $jsonResponse): void
    {
        $valid = $this->jsonSchemaCheck->check(
          json_decode($jsonResponse),
          __DIR__.'/../JSONSchema/CustomersSchema.json'
        );
        if (!$valid) {
            throw new \Exception(
              'Finance Consult API dosen\'t sent valid JSON schema. Contact fc support or update the schema.'
            );
        }
    }
}
