<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\DataClient;

use Gonetto\FCApiClientBundle\Model\Contract;
use Gonetto\FCApiClientBundle\Model\Customer;
use Gonetto\FCApiClientBundle\Model\DataResponse;
use Gonetto\FCApiClientBundle\Model\Document;
use Gonetto\FCApiClientBundle\Service\ApiClient;
use Gonetto\FCApiClientBundle\Service\DataClient;
use Gonetto\FCApiClientBundle\Service\ResponseMapper;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class GetAllSinceTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Service\DataClient
 */
class GetAllTest extends WebTestCase
{

    /** @var ApiClient|\PHPUnit_Framework_MockObject_MockObject */
    protected $apiClient;

    /** @var DataResponse */
    protected $data;

    /** @var DataClient */
    protected $dataClient;

    /**
     * {@inheritDoc}
     *
     * @throws \Exception
     */
    protected function setUp()
    {
        // Mock api client
        $this->mockApiClient();

        // Load result
        $this->loadDataFixtures();
    }

    /**
     * Setup client for mock.
     */
    protected function mockApiClient()
    {
        // Api response
        $json = file_get_contents(__DIR__.'/ApiDataResponse.json');

        // Mock client
        $this->apiClient = $this->createMock(ApiClient::class);
        $this->apiClient->method('send')->willReturn($json);

        // Pass mocked api client to customer client
        $this->dataClient = new DataClient('', $this->apiClient, new ResponseMapper());
    }

    /**
     * @throws \Exception
     */
    protected function loadDataFixtures()
    {
        // TODO:GN:MS: Test alte response zu neuer convertieren?!

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
                    ->setMainRenewalDate(new \DateTime('2006-04-01'))
                    ->setInsuranceType('Wohngebäude')
                    ->setContractDate(new \DateTime('2018-03-27T11:21:37'))
                    ->setEndOfContract(new \DateTime('2019-04-01'))
                    ->setContractNumber('2397868001')
                    ->setPaymentInterval(1)
            )
            ->addContractDeleted('AB45U')
            ->addDocument(
                (new Document())
                    ->setFianceConsultId('1B5O3V')
                    ->setContractId('19DB5Y')
                    ->setType(2)
                    // TODO:GN:MS: wie bei zahlweise mapper auch art mapper bauen, aber clsse mit values? und generiert aus csv/yml?!
                    ->setDate(new \DateTime('2019-02-04T13:26:58'))
            )
            ->addDocumentDeleted('19CTC5');
    }

    /**
     * Test map() customers with addresses and contacts.
     *
     * @throws \Exception
     */
    public function testGetAllSince()
    {
        // Deserialize JSON with JMS Serializer
        $dataResponse = $this->dataClient->getAll();

        // Compare result
        $this->assertEquals($this->data, $dataResponse);
    }
}
