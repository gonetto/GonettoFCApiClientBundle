<?php

namespace Gonetto\FCApiClientBundle\Tests\Model\DataResponse;

use DateTime;
use Gonetto\FCApiClientBundle\Model\Contract;
use Gonetto\FCApiClientBundle\Model\Customer;
use Gonetto\FCApiClientBundle\Model\DataResponse;
use Gonetto\FCApiClientBundle\Model\Document;
use Gonetto\FCApiClientBundle\Service\JmsSerializerFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class GetAllTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Service\DataClient\GetAll
 */
class SerializeTest extends KernelTestCase
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
                    ->setFianceConsultId('19P1CF')
                    ->setEmail('anna.musterfrau@domain.tld')
                    ->setFirstName('Anna')
                    ->setLastName('Musterfrau')
                    ->setCompany('Beispielfirma')
                    ->setStreet('Beispielstr. 2')
                    ->setZipCode(54321)
                    ->setCity('Beispielstadt')
                    ->setIban('DE02500105170137075030')
            )
            ->addCustomerDeleted('1B6PS1')
            ->addContract(
                (new Contract())
                    ->setFianceConsultId('SB1CK')
                    ->setCustomerId('19P1CF')
                    ->setFee(656.9)
                    ->setInsurer('DEVK Versicherungen')
                    ->setMainRenewalDate(new DateTime('2006-04-01'))
                    ->setInsuranceType('Wohngebäude')
                    ->setContractDate(new DateTime('2018-03-27T11:21:37'))
                    ->setEndOfContract(new DateTime('2019-04-01'))
                    ->setPolicyNumber('2397868001')
                    ->setPaymentInterval(1)
            )
            ->addContractDeleted('AB45U')
            ->addDocument(
                (new Document())
                    ->setFianceConsultId('1B5O3V')
                    ->setContractId('19DB5Y')
                    ->setType('Antrag')
                    ->setDate(new DateTime('2019-02-04T13:26:58'))
            )
            ->addDocumentDeleted('19CTC5');
    }

    /**
     * Test map() customers with addresses and contacts.
     *
     * @test
     *
     * @throws \Exception
     */
    public function testResponse()
    {
        // Deserialize JSON
        $jsonResponse = file_get_contents(__DIR__.'/DataResponse.json');
        $dataResponse = $this->serializer->deserialize($jsonResponse, DataResponse::class, 'json');

        // Compare result
        $this->assertEquals($this->data, $dataResponse);
    }
}
