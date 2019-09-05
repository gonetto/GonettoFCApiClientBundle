<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\DataClient\GetAll;

use Gonetto\FCApiClientBundle\Model\DataResponse;
use Gonetto\FCApiClientBundle\Tests\ClientTestCase;

class GetAllTest extends ClientTestCase
{

    /** @var \Gonetto\FCApiClientBundle\Service\DataClient */
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

        $json = file_get_contents(__DIR__.'/ApiDataResponse.json');
        $this->dataClient = $this->mockGuzzleClientInDataClient($json);
    }

    /**
     * @throws \Exception
     */
    public function testResponse(): void
    {
        $dataResponse = $this->dataClient->getAll();
        $this->assertInstanceOf(DataResponse::class, $dataResponse);
        $this->assertCount(1, $dataResponse->getCustomers());
        $this->assertCount(1, $dataResponse->getContracts());
    }
}
