<?php

namespace Gonetto\FCApiClientBundle\Service;

use Gonetto\FCApiClientBundle\Model\DataRequest;
use Gonetto\FCApiClientBundle\Model\DataResponse;
use Gonetto\FCApiClientBundle\Model\Document;
use Gonetto\FCApiClientBundle\Model\FileRequest;
use Gonetto\FCApiClientBundle\Model\RequestInterface;
use JMS\Serializer\SerializerBuilder;
use JsonSchema\Validator;

/**
 * Class DataClient
 *
 * @package Gonetto\FCApiClientBundle\Service
 */
class DataClient
{

    // TODO:GN:MS: DataClient file abholen schnittstelle

    /** @var \Gonetto\FCApiClientBundle\Service\ApiClient */
    protected $client;

    /** @var \Gonetto\FCApiClientBundle\Service\DataRequestFactory */
    protected $dataRequest;

    /** @var \Gonetto\FCApiClientBundle\Model\FileRequest */
    protected $fileRequest;

    /** @var \Gonetto\FCApiClientBundle\Service\ResponseMapper */
    protected $responseMapper;

    /** @var \JMS\Serializer\Serializer */
    protected $serializer;

    /** @var \JsonSchema\Validator */
    protected $validator;

    /**
     * DataClient constructor.
     *
     * @param \Gonetto\FCApiClientBundle\Service\ApiClient $client
     * @param \Gonetto\FCApiClientBundle\Model\DataRequest $dataRequest
     * @param \Gonetto\FCApiClientBundle\Model\FileRequest $fileRequest
     * @param \Gonetto\FCApiClientBundle\Service\ResponseMapper $responseMapper
     */
    public function __construct(
        ApiClient $client,
        DataRequest $dataRequest,
        FileRequest $fileRequest,
        ResponseMapper $responseMapper
    ) {
        $this->client = $client;
        $this->dataRequest = $dataRequest;
        $this->fileRequest = $fileRequest;
        $this->responseMapper = $responseMapper;

        $this->serializer = (new SerializerBuilder())->build();
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
        $dataResponse = $this->responseMapper->map($jsonResponse);

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
        $fileResponse = $this->responseMapper->map($jsonResponse);
        // FIXME:GN:MS: factory service draus machen und richtig files mappen

        return $fileResponse;
    }

    /**
     * @param \Gonetto\FCApiClientBundle\Model\RequestInterface $request
     *
     * @return string
     * @throws \Exception
     */
    protected function sendRequest(RequestInterface $request)
    {
        $body = $this->serializer->serialize($request, 'json');
        $jsonResponse = $this->client->send(['body' => $body]);

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
