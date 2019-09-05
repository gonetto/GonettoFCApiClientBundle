<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\DataClient;

use Gonetto\FCApiClientBundle\Model\DataResponse;
use Gonetto\FCApiClientBundle\Service\DataClient;
use Gonetto\FCApiClientBundle\Tests\ClientTestCase;

class DeprecatedGetAllTest extends ClientTestCase
{

    /** @var DataClient */
    protected $dataClient;

    /**
     * GetFileTest constructor.
     *
     * @param null $name
     * @param array $data
     * @param string $dataName
     *
     * @throws \Exception
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $json = file_get_contents(__DIR__.'/DeprecatedApiDataResponse.json');
        $this->dataClient = $this->mockGuzzleClientInDataClient($json);
    }

    /**
     * @throws \Exception
     */
    public function testGetAllSince(): void
    {
        // Deserialize JSON with JMS Serializer
        $dataResponse = $this->dataClient->getAll();

        // Check customer
        $this->assertInstanceOf(DataResponse::class, $dataResponse);
        $this->assertCount(1, $dataResponse->getCustomers());

        // Check contract – test refactored structure
        /** @var \Gonetto\FCApiClientBundle\Model\Customer $customer */
        $customer = $dataResponse->getCustomers()[0];
        $this->assertCount(0, $customer->getContracts());
        $this->assertCount(1, $dataResponse->getContracts());
    }
}
