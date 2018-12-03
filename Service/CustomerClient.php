<?php

namespace Gonetto\FCApiClientBundle\Service;

/**
 * Class CustomerClient
 *
 * @package Gonetto\FCApiClientBundle\Service
 */
class CustomerClient
{

    /** @var ApiClient */
    protected $client;

    /** @var string */
    protected $financeConsultApiAccessToken;

    /** @var JSONSchemaCheck */
    protected $jsonSchemaCheck;

    /** @var ResponseMapper */
    protected $responseMapper;

    /**
     * CustomerClient constructor.
     *
     * @param string $token
     * @param ApiClient $client
     * @param JSONSchemaCheck $jsonSchemaCheck
     * @param ResponseMapper $responseMapper
     */
    public function __construct(
      string $token,
      ApiClient $client,
      JSONSchemaCheck $jsonSchemaCheck,
      ResponseMapper $responseMapper
    ) {
        $this->financeConsultApiAccessToken = $token;
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
        // Build api request
        $body = $this->createApiRequestBody($since);

        // Get json from api
        $jsonResponse = $this->client->send(['body' => $body]);

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
    protected function createApiRequestBody(\DateTime $since = null): string
    {
        return json_encode(
          [
            'token' => $this->financeConsultApiAccessToken,
            'since' => $since ? $since->format('Y-m-d\TH:i:s.v\Z') : '',
          ]
        );
    }

    /**
     * @param string $jsonResponse
     *
     * @throws \Exception
     */
    protected function jsonSchemaCheck(string $jsonResponse): void
    {
        $valid = $this->jsonSchemaCheck->check(
          $jsonResponse,
          __DIR__.'/../JSONSchema/CustomersSchema.json'
        );
        if (!$valid) {
            throw new \Exception(
              'Finance Consult API dosen\'t sent valid JSON schema. Contact fc support or update the schema.'
            );
        }
    }
}
