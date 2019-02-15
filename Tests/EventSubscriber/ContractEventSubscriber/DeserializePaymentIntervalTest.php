<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\ResponseMapper\Minimum;

use Gonetto\FCApiClientBundle\Model\Contract;
use Gonetto\FCApiClientBundle\Model\DataResponse;
use Gonetto\FCApiClientBundle\Service\ResponseMapper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class ResponseMapperTest
 *
 * @package Tests\Gonetto\FCApiClientBundle\Service
 */
class DeserializePaymentIntervalTest extends KernelTestCase
{

    /** @var ResponseMapper */
    protected $responseMapper;

    /** @var \Gonetto\FCApiClientBundle\Model\DataResponse */
    protected $data;

    /**
     * {@inheritDoc}
     *
     * @throws \Exception
     */
    protected function setUp()
    {
        $this->responseMapper = new ResponseMapper();

        $this->loadDataFixtures();
    }

    /**
     * Test map() customers with addresses and contacts.
     *
     * @throws \Exception
     */
    public function testMapCustomers()
    {
        // Deserialize JSON
        $json = file_get_contents(__DIR__.'/ApiDataResponse.json');
        $dataResponse = $this->responseMapper->map($json);

        // Compare result
        $this->assertEquals($this->data, $dataResponse);
    }

    /**
     * @throws \Exception
     */
    protected function loadDataFixtures()
    {
        $this->data = (new DataResponse())
            ->setContracts(
                [
                    (new Contract())->setPaymentInterval(12),
                    (new Contract())->setPaymentInterval(4),
                    (new Contract())->setPaymentInterval(2),
                    (new Contract())->setPaymentInterval(1),
                    (new Contract())->setPaymentInterval(0),
                ]
            );
    }
}
