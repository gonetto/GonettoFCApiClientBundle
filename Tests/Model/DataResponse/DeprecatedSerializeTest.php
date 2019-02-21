<?php

namespace Gonetto\FCApiClientBundle\Tests\Model\DataResponse;

use Gonetto\FCApiClientBundle\Model\Contract;
use Gonetto\FCApiClientBundle\Model\Customer;
use Gonetto\FCApiClientBundle\Model\DataResponse;
use Gonetto\FCApiClientBundle\Service\JmsSerializerFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class GetAllTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Service\DataClient\GetAll
 */
class DeprecatedSerializeTest extends KernelTestCase
{

    /** @var \Gonetto\FCApiClientBundle\Model\DataResponse */
    protected $data;

    /** @var \JMS\Serializer\Serializer */
    protected $serializer;

    /**
     * {@inheritDoc}
     *
     * @throws \Exception
     */
    protected function setUp()
    {
        $this->serializer = (new JmsSerializerFactory())->createSerializer();

        $this->loadDataFixtures();
    }

    /**
     * @throws \Exception
     */
    protected function loadDataFixtures()
    {
        $this->data = (new DataResponse())
            ->addCustomer(
                (new Customer())
                    ->setFianceConsultId('RD1PP')
                    ->setEmail('max.mustermann@domain.tld')
                    ->setFirstName('Max')
                    ->setLastName('Mustermann')
                    ->setCompany('Musterfirma')
                    ->setStreet('Musterstr. 1')
                    ->setZipCode(12345)
                    ->setCity('Musterstadt')
                    ->setIban('DE02120300000000202051')
                    ->addContract(
                        (new Contract())
                            ->setFianceConsultId('RD1PN')
                            ->setFee(82.23)
                            ->setInsurer('Allianz Versicherungs-AG')
                            ->setMainRenewalDate(new \DateTime('2017-08-01'))
                            ->setInsuranceType('Unfall')
                            ->setContractDate(new \DateTime('2018-06-15T11:47:49'))
                            ->setEndOfContract(new \DateTime('2019-08-01'))
                            ->setPolicyNumber('4864516/213')
                            ->setPaymentInterval(12)
                    )
            );
    }

    /**
     * Test map() customers with addresses and contacts.
     *
     * @throws \Exception
     */
    public function testResponse()
    {
        // Deserialize JSON
        $jsonResponse = file_get_contents(__DIR__.'/DeprecatedDataResponse.json');
        $dataResponse = $this->serializer->deserialize($jsonResponse, DataResponse::class, 'json');

        // Compare result
        $this->assertEquals($this->data, $dataResponse);
    }
}
