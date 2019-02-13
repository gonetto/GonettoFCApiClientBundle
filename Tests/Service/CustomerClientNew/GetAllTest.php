<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\CustomerClientNew;

use Gonetto\FCApiClientBundle\Model\Contract;
use Gonetto\FCApiClientBundle\Model\Customer;
use Gonetto\FCApiClientBundle\Model\Document;
use Gonetto\FCApiClientBundle\Service\ApiClient;
use Gonetto\FCApiClientBundle\Service\CustomerClient;
use Gonetto\FCApiClientBundle\Service\ResponseMapper;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class GetAllSinceTest
 *
 * @package Gonetto\FCApiClientBundle\Tests\Service\CustomerClient
 */
class GetAllTest extends WebTestCase
{

    /** @var ApiClient|\PHPUnit_Framework_MockObject_MockObject */
    protected $apiClient;

    /** @var array of Customers with Contracts */
    protected $customers;

    /** @var CustomerClient */
    protected $customerClient;

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
        $this->customerClient = new CustomerClient('', $this->apiClient, new ResponseMapper());
    }

    /**
     * @throws \Exception
     */
    protected function loadDataFixtures()
    {
        // TODO:GN:MS: Test alte response zu neuer convertieren?!

        // TODO:GN:MS: Alte Struktur als depricated markieren

        // TODO:GN:MS: Customer client entfernen und als depricated markieren

        // TODO:GN:MS: JSON Schema umbauen. Aber so, das die alte Struktur funktioniert!

        // TODO:GN:MS: Test neue Struktur

        $this->customers = [
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
                /*
                ->setContracts(
                    [
                        (new Contract())
                            ->setFianceConsultId('SB1CK')
                            ->setFee(656.9)
                            ->setInsurer('DEVK Versicherungen')
                            ->setGonettoContractNumber(345)
                            ->setMainRenewalDate(new \DateTime('2006-04-01'))
                            ->setInsuranceType('Wohngebäude')
                            ->setContractDate(new \DateTime('2018-03-27T11:21:37'))
                            ->setEndOfContract(new \DateTime('2019-04-01'))
                            ->setFinanceConsultContractNumber('2397868001')
                            ->setContractNumber('2397868001')
                            ->setPaymentInterval(1),
                    ]
                )
                */
                /*
                ->setDocuments(
                    [
                        (new Document())
                            ->setFianceConsultId('1B5O3V')
                            ->setUrl('DCS5Net/DocumentView.aspx?KundeDokumentID=21791188')
                            ->setType('')
                            ->setAddDate(new \DateTime('2019-01-18'))
                            ->setAddedBy('docsu'),
                    ]
                ),
                */
        ];
    }

    /**
     * Test map() customers with addresses and contacts.
     *
     * @throws \Exception
     */
    public function testGetAllSince()
    {
        // Deserialize JSON with JMS Serializer
        $customers = $this->customerClient->getAll();

        // Compare result
        $this->assertEquals($this->customers, $customers);
    }
}
