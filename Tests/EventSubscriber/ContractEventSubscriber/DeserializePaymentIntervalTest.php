<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\ResponseMapper\Minimum;

use Gonetto\FCApiClientBundle\Model\Contract;
use Gonetto\FCApiClientBundle\Model\Customer;
use Gonetto\FCApiClientBundle\Service\ResponseMapper;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ResponseMapperTest
 *
 * @package Tests\Gonetto\FCApiClientBundle\Service
 */
class DeserializePaymentIntervalTest extends WebTestCase
{

    /** @var ResponseMapper */
    protected $responseMapper;

    /** @var array of Customers with Contracts */
    protected $customers;

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
        // Deserialize JSON with JMS Serializer
        $json = file_get_contents(__DIR__.'/FinanceConsultApiResponse.json');
        $customers = $this->responseMapper->map($json);

        // Compare result
        $this->assertEquals($this->customers, $customers);
    }

    /**
     * @throws \Exception
     */
    protected function loadDataFixtures()
    {
        $this->customers = [
          (new Customer())->setContracts(
            [
              (new Contract())->setPaymentInterval(12),
              (new Contract())->setPaymentInterval(4),
              (new Contract())->setPaymentInterval(2),
              (new Contract())->setPaymentInterval(1),
              (new Contract())->setPaymentInterval(0),
            ]
          ),
        ];
    }
}
