<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\DataClient;

use Gonetto\FCApiClientBundle\Model\DataResponse;
use Gonetto\FCApiClientBundle\Service\ApiClient;
use Gonetto\FCApiClientBundle\Service\DataClient;
use Gonetto\FCApiClientBundle\Service\DataRequestFactory;
use Gonetto\FCApiClientBundle\Service\FileRequestFactory;
use Gonetto\FCApiClientBundle\Service\ResponseMapper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class GetAllSinceTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Service\DataClient
 */
class CreateApiRequestBodyTest extends KernelTestCase
{

    /** @var ApiClient|\PHPUnit_Framework_MockObject_MockObject */
    protected $apiClient;

    /** @var DataResponse */
    protected $data;

    /** @var DataClient */
    protected $dataClient;

    /** @var array */
    protected $dataRequest;

    /**
     * {@inheritDoc}
     *
     * @throws \Exception
     */
    protected function setUp()
    {
        // Mock api client
        $this->mockApiClient();
    }

    /**
     * Setup client for mock.
     */
    protected function mockApiClient()
    {
        // Mock client
        $this->apiClient = $this->createMock(ApiClient::class);
        $this->apiClient->method('send')
            ->will(
                $this->returnCallback(
                    function ($parameter) {
                        // Note api request
                        $this->dataRequest = $parameter;

                        // Return api response
                        return '{}';
                    }
                )
            );

        // Pass mocked api client to customer client
        $this->dataClient = new DataClient(
            $this->apiClient,
            (new DataRequestFactory('8029fdd175474c61909ca5f0803965bb464ff546'))->createResponse(),
            (new FileRequestFactory(''))->createResponse(),
            new ResponseMapper()
        );
    }

    /**
     * Test map() customers with addresses and contacts.
     *
     * @throws \Exception
     */
    public function testCreateApiRequestBody_all()
    {
        // Make request
        $this->dataClient->getAll();

        // Compare request json
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/ApiDataRequest-getAll.json', $this->dataRequest['body']);
    }

    /**
     * Test map() customers with addresses and contacts.
     *
     * @throws \Exception
     */
    public function testCreateApiRequestBody_allSince()
    {
        // Make request
        $this->dataClient->getAllSince(new \DateTime('2019-02-15'));

        // Compare request json
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/ApiDataRequest-getAllSince.json', $this->dataRequest['body']);
    }
}
