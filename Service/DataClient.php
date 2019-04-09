<?php

namespace Gonetto\FCApiClientBundle\Service;

use Gonetto\FCApiClientBundle\Model\Customer;
use Gonetto\FCApiClientBundle\Model\CustomerUpdateRequest;
use Gonetto\FCApiClientBundle\Model\CustomerUpdateResponse;
use Gonetto\FCApiClientBundle\Model\DataRequest;
use Gonetto\FCApiClientBundle\Model\DataResponse;
use Gonetto\FCApiClientBundle\Model\Document;
use Gonetto\FCApiClientBundle\Model\FileRequest;
use Gonetto\FCApiClientBundle\Model\FileResponse;
use Gonetto\FCApiClientBundle\Model\RequestInterface;
use GuzzleHttp\Client;
use JMS\Serializer\Serializer;
use JsonSchema\Validator;

/**
 * Class DataClient
 *
 * @package Gonetto\FCApiClientBundle\Service
 */
class DataClient
{

    /** @var \GuzzleHttp\Client */
    protected $client;

    /** @var \Gonetto\FCApiClientBundle\Model\CustomerUpdateRequest */
    protected $customerUpdateRequest;

    /** @var \Gonetto\FCApiClientBundle\Service\DataRequestFactory */
    protected $dataRequest;

    /** @var \Gonetto\FCApiClientBundle\Model\FileRequest */
    protected $fileRequest;

    /** @var string */
    protected $financeConsultApiPath;

    /** @var \JMS\Serializer\Serializer */
    protected $serializer;

    /** @var \JsonSchema\Validator */
    protected $validator;

    /**
     * DataClient constructor.
     *
     * @param string $financeConsultApiPath
     * @param \GuzzleHttp\Client $client
     * @param \Gonetto\FCApiClientBundle\Model\CustomerUpdateRequest $customerUpdateRequest
     * @param \Gonetto\FCApiClientBundle\Model\DataRequest $dataRequest
     * @param \Gonetto\FCApiClientBundle\Model\FileRequest $fileRequest
     * @param \JMS\Serializer\Serializer $serializer
     */
    public function __construct(
        string $financeConsultApiPath,
        Client $client,
        CustomerUpdateRequest $customerUpdateRequest,
        DataRequest $dataRequest,
        FileRequest $fileRequest,
        Serializer $serializer
    ) {
        $this->financeConsultApiPath = $financeConsultApiPath;
        $this->client = $client;
        $this->customerUpdateRequest = $customerUpdateRequest;
        $this->dataRequest = $dataRequest;
        $this->fileRequest = $fileRequest;
        $this->serializer = $serializer;

        $this->validator = new Validator();
    }

    /**
     * Get all customers from Finance Consult API
     *
     * @param bool $get_src_json
     *
     * @return \Gonetto\FCApiClientBundle\Model\DataResponse|string
     * @throws \Exception
     */
    public function getAll($get_src_json = false)
    {
        return $this->getAllSince(null, $get_src_json);
    }

    /**
     * Get all customers from Finance Consult API since specific date
     *
     * @param \DateTime|null $since
     * @param bool $get_src_json
     *
     * @return \Gonetto\FCApiClientBundle\Model\DataResponse|string
     * @throws \Exception
     */
    public function getAllSince(\DateTime $since = null, $get_src_json = false)
    {
        // Prepare request
        $this->dataRequest->setSinceDate($since);

        // Send request
        $jsonResponse = $this->sendRequest($this->dataRequest);

        // Check response
        $this->jsonSchemaCheck($jsonResponse, 'DataResponseSchema');

        // Return json string
        if ($get_src_json) {
            return $jsonResponse;
        }

        // Map json to object
        /** @var DataResponse $dataResponse */
        $dataResponse = $this->serializer->deserialize($jsonResponse, DataResponse::class, 'json');

        // Refactor deprecated response
        $dataResponse = $this->moveDeprecatedNestedContracts($dataResponse);

        return $dataResponse;
    }

    /**
     * @param \Gonetto\FCApiClientBundle\Model\Document $document
     * @param bool $get_src_json
     *
     * @return \Gonetto\FCApiClientBundle\Model\FileResponse|string
     * @throws \Exception
     */
    public function getFile(Document $document, $get_src_json = false)
    {
        // Prepare request
        $this->fileRequest
            ->setDocumentId($document->getFianceConsultId())
            ->setContractId($document->getContractId());

        // Send request
        $jsonResponse = $this->sendRequest($this->fileRequest);

        // Check response
        $this->jsonSchemaCheck($jsonResponse, 'FileResponseSchema');

        // Return json string
        if ($get_src_json) {
            return $jsonResponse;
        }

        // Map json to object
        /** @var FileResponse $fileResponse */
        $fileResponse = $this->serializer->deserialize($jsonResponse, FileResponse::class, 'json');

        return $fileResponse;
    }

    /**
     * @param \Gonetto\FCApiClientBundle\Model\Customer $customer
     *
     * @return string
     * @throws \Exception
     */
    public function updateCustomer(Customer $customer)
    {
        // Prepare request object
        $this->customerUpdateRequest->clone($customer);

        // Send request
        $jsonResponse = $this->sendRequest($this->customerUpdateRequest);

        // Check response
        $this->jsonSchemaCheck($jsonResponse, 'CustomerUpdateResponseSchema');

        // Map json to object
        /** @var FileResponse $fileResponse */
        $customerUpdateResponse = $this->serializer->deserialize($jsonResponse, CustomerUpdateResponse::class, 'json');

        return $customerUpdateResponse;
    }

    /**
     * @param \Gonetto\FCApiClientBundle\Model\RequestInterface $request
     *
     * @return string
     * @throws \Exception
     */
    protected function sendRequest(RequestInterface $request)
    {
        // Prepare request
        $body = $this->serializer->serialize($request, 'json');

        // Send request
        $stream = $this->client->get($this->financeConsultApiPath, ['body' => $body]);
        $jsonResponse = (string)$stream->getBody();

        // Check if not valid JSON response
        if (json_decode($jsonResponse) === null) {
            throw new \Exception(
                'Finance Consult API dosen\'t sent valid JSON. Check the response.'
                .' (Response: "'.$jsonResponse.'")'
            );
        }

        return $jsonResponse;
    }

    /**
     * @param string $jsonResponse
     * @param string $schema
     *
     * @throws \Exception
     */
    protected function jsonSchemaCheck(string $jsonResponse, string $schema): void
    {
        $response = json_decode($jsonResponse);
        $this->validator->validate(
            $response,
            (object)['$ref' => 'file://'.__DIR__.'/../JSONSchema/'.$schema.'.json']
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
    protected function moveDeprecatedNestedContracts(DataResponse $dataResponse): DataResponse
    {
        // Search nested contracts
        /** @var \Gonetto\FCApiClientBundle\Model\Customer $customer */
        foreach ($dataResponse->getCustomers() as &$customer) {
            /** @var \Gonetto\FCApiClientBundle\Model\Contract $contract */
            foreach ($customer->getContracts() as $contract) {

                // Set customer id to contract
                $contract->setCustomerId($customer->getFianceConsultId());

                // Safe contract to root list
                $dataResponse->addContract($contract);

                // Remove contract from nested list
                $customer->removeContract($contract);
            }
        }

        return $dataResponse;
    }
}
