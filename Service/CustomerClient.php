<?php

namespace Gonetto\FCApiClientBundle\Service;

use Gonetto\FCApiClientBundle\Model\Customer;
use Gonetto\FCApiClientBundle\Model\DataResponse;
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

    /** @var ResponseMapper */
    protected $responseMapper;

    /**
     * CustomerClient constructor.
     *
     * @param string $token
     * @param ApiClient $client
     * @param ResponseMapper $responseMapper
     */
    public function __construct(
        string $token,
        ApiClient $client,
        ResponseMapper $responseMapper
    ) {
        $this->financeConsultApiAccessToken = $token;
        $this->client = $client;
        $this->responseMapper = $responseMapper;

        $this->validator = new Validator();
    }

    /**
     * Get all customers from Finance Consult API
     *
     * @param bool $get_src_json
     *
     * @return array|string
     * @throws \Exception
     */
    public function getAll($get_src_json = false): array
    {
        return $this->getAllSince(null, $get_src_json);
    }

    /**
     * Get all customers from Finance Consult API since specific date
     *
     * @param \DateTime|null $since
     * @param bool $get_src_json
     *
     * @return array|string
     * @throws \Exception
     */
    public function getAllSince(\DateTime $since = null, $get_src_json = false): array
    {
        // Build api request
        $body = $this->createApiRequestBody($since);

        // Get json from api
        $jsonResponse = $this->client->send(['body' => $body]);

        // Check json
        $this->jsonSchemaCheck($jsonResponse);

        // Return json string src
        if ($get_src_json) {
            return $jsonResponse;
        }

        // Map json to object
        $dataResponse = $this->responseMapper->map($jsonResponse);

        // Refactor new response to deprecated structure
        $dataResponse = $this->moveContractsToDeprecatedNested($dataResponse);
        $customers = $dataResponse->getCustomers();

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
