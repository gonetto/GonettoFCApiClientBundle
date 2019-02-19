<?php

namespace Gonetto\FCApiClientBundle\Service;

use Gonetto\FCApiClientBundle\Model\Customer;
use Gonetto\FCApiClientBundle\Model\DataResponse;
use JMS\Serializer\Serializer;
use JsonSchema\Validator;

/**
 * Class CustomerClient
 *
 * @package Gonetto\FCApiClientBundle\Service
 *
 * @deprecated
 * @see \Gonetto\FCApiClientBundle\Service\DataClient
 */
class CustomerClient
{

    /** @var ApiClient */
    protected $client;

    /** @var string */
    protected $financeConsultApiAccessToken;

    /** @var \JsonSchema\Validator */
    protected $validator;

    /** @var \JMS\Serializer\Serializer */
    protected $serializer;

    /**
     * CustomerClient constructor.
     *
     * @param string $token
     * @param ApiClient $client
     * @param \JMS\Serializer\Serializer $serializer
     */
    public function __construct(
        string $token,
        ApiClient $client,
        Serializer $serializer
    ) {
        $this->financeConsultApiAccessToken = $token;
        $this->client = $client;
        $this->serializer = $serializer;

        $this->validator = new Validator();
    }

    /**
     * Get all customers from Finance Consult API
     *
     * @return array
     * @throws \Exception
     */
    public function getAll(): array
    {
        return $this->getAllSince(null);
    }

    /**
     * Get all customers from Finance Consult API since specific date
     *
     * @param \DateTime|null $since
     *
     * @return array
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
        $dataResponse = $this->serializer->deserialize($jsonResponse, DataResponse::class, 'json');

        // Refactor new response to deprecated structure
        $dataResponse = $this->moveContractsToDeprecatedNested($dataResponse);
        $customers = $dataResponse->getCustomers();

        return $customers;
    }

    /**
     * Get all customers from Finance Consult API
     *
     * @return string
     * @throws \Exception
     */
    public function getAllJson(): string
    {
        return $this->getAllSinceJson(null);
    }

    /**
     * Get all customers from Finance Consult API since specific date
     *
     * @param \DateTime|null $since
     *
     * @return string
     * @throws \Exception
     */
    public function getAllSinceJson(\DateTime $since = null): string
    {
        // Build api request
        $body = $this->createApiRequestBody($since);

        // Get json from api
        $jsonResponse = $this->client->send(['body' => $body]);

        // Check json
        $this->jsonSchemaCheck($jsonResponse);

        // Return json string src
        return $jsonResponse;
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
        $response = json_decode($jsonResponse);
        $this->validator->validate(
            $response,
            (object)['$ref' => 'file://'.__DIR__.'/../JSONSchema/DataResponseSchema.json']
        );
        if (!$this->validator->isValid()) {
            throw new \Exception(
                'Finance Consult API dosen\'t sent valid JSON schema. Contact fc support or update the schema.'.PHP_EOL
                .print_r($this->validator->getErrors(), true)
            );
        }
    }

    /**
     * @param \Gonetto\FCApiClientBundle\Model\DataResponse $dataResponse
     *
     * @return \Gonetto\FCApiClientBundle\Model\DataResponse
     */
    protected function moveContractsToDeprecatedNested(DataResponse $dataResponse): DataResponse
    {
        // Move contracts in customer nested
        /** @var \Gonetto\FCApiClientBundle\Model\Contract $contract */
        foreach ($dataResponse->getContracts() as $contract) {

            // Find matching user
            $found = false;
            /** @var \Gonetto\FCApiClientBundle\Model\Customer $customer */
            foreach ($dataResponse->getCustomers() as &$customer) {
                // Skip not matching user
                if ($contract->getCustomerId() !== $customer->getFianceConsultId()) {
                    continue;
                }

                // Safe contract to customer
                $customer->addContract($contract);

                // Remove contract from nested list
                $dataResponse->removeContract($contract);

                $found = true;
                break;
            }

            // Add not founded user
            if (!$found) {
                $dataResponse->addCustomer(
                    (new Customer())
                        ->setFianceConsultId($contract->getCustomerId())
                        ->addContract($contract)
                );
            }
        }

        return $dataResponse;
    }
}
