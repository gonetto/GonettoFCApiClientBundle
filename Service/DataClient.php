<?php

namespace Gonetto\FCApiClientBundle\Service;

use DateTime;
use Exception;
use Gonetto\FCApiClientBundle\Model\Customer;
use Gonetto\FCApiClientBundle\Model\CustomerUpdate;
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
use TypeError;

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
    public function getAllSince(DateTime $since = null, $get_src_json = false)
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
        // Check parameters
        if (empty($document->getFinanceConsultId())) {
            throw new Exception('FinanceConsultId can not be empty');
        }
        if (empty($document->getContractId())) {
            throw new Exception('ContractId can not be empty');
        }

        // Prepare request
        $this->fileRequest
            ->setDocumentId($document->getFinanceConsultId())
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
     * @param \Gonetto\FCApiClientBundle\Model\CustomerUpdate $customerUpdate
     *
     * @return CustomerUpdateResponse
     * @throws \Exception
     *
     * @example error: {"result":false, "error":"Objekt konnte nicht gesperrt werden."} // Try later again
     * @example error: {"result":false, "error":"OID ungültig oder keine Berechtigung."} // Check FC customer ID
     */
    public function sendCustomerUpdate(CustomerUpdate $customerUpdate): CustomerUpdateResponse
    {
        // Check id
        try {
            $customerUpdate->getFinanceConsultId();
        } catch (TypeError $e) {
            return (new CustomerUpdateResponse())
                ->setSuccess(false)
                ->setErrorMessage('The finance consult id is needed.');
        }

        // Prepare request object
        $this->customerUpdateRequest->clone($customerUpdate);

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
    protected function sendRequest(RequestInterface $request): string
    {
        // Prepare request
        $body = $this->serializer->serialize($request, 'json');

        // Send request
        $stream = $this->client->get($this->financeConsultApiPath, ['body' => $body]);
        $jsonResponse = (string)$stream->getBody();

        // Check if not valid JSON response
        if (json_decode($jsonResponse, false) === null) {
            throw new Exception(
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
        $response = json_decode($jsonResponse, false);
        $this->validator->validate($response, (object)['$ref' => 'file://'.__DIR__.'/../JSONSchema/'.$schema.'.json']);
        if (!$this->validator->isValid()) {
            // If error
            $this->errorJsonSchemaCheck($jsonResponse);

            // If really unknown json format
            throw new Exception(
                'Finance Consult API dosen\'t sent valid JSON schema. Contact fc support or update the schema.'.PHP_EOL
                .print_r($this->validator->getErrors(), true)
            );
        }
    }

    /**
     * @param string $jsonResponse
     *
     * @throws \Exception
     */
    protected function errorJsonSchemaCheck($jsonResponse): void
    {
        $response = json_decode($jsonResponse, false);
        $validator = new Validator();
        $validator->validate($response, (object)['$ref' => 'file://'.__DIR__.'/../JSONSchema/ErrorSchema.json']);
        if ($validator->isValid()) {
            throw new Exception(
                'Finance Consult API sent unexpected answer: '.PHP_EOL
                .print_r($response, true).PHP_EOL
                .'Maybe check the submitted Fiance Consult ID\'s.'
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
                $contract->setCustomerId($customer->getFinanceConsultId());

                // Safe contract to root list
                $dataResponse->addContract($contract);

                // Remove contract from nested list
                $customer->removeContract($contract);
            }
        }

        return $dataResponse;
    }
}
