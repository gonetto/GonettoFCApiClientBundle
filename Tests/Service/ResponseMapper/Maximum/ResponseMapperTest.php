<?php

namespace Gonetto\FCApiClientBundle\Tests\Service\ResponseMapper;

use Gonetto\FCApiClientBundle\Model\Contract;
use Gonetto\FCApiClientBundle\Model\Customer;
use Gonetto\FCApiClientBundle\Service\ResponseMapper;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ResponseMapperTest
 *
 * @package Tests\Gonetto\FCApiClientBundle\Service
 */
class ResponseMapperTest extends WebTestCase
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
          (new Customer())
            ->setEmail('max.mustermann@web.de')
            ->setFirstName('Max')
            ->setLastName('Mustermann')
            ->setCompany('Musterfirma')
            ->setStreet('Musterstr. 1')
            ->setZipCode(12345)
            ->setCity('Musterstadt')
            ->setIban('DE02120300000000202051')
            ->setContracts(
              [
                (new Contract())
                  ->setFee(875.16)
                  ->setInsurer('Hallesche Krankenversicherung')
                  ->setGonettoContractNumber(123)
                  ->setMainRenewalDate(new \DateTime('1998-10-01'))
                  ->setInsuranceType('KV-Substitutiv')
                  ->setContractDate(new \DateTime('2018-07-24T13:25:38'))
                  ->setEndOfContract(new \DateTime('2019-10-01'))
                  ->setFinanceConsultContractNumber('29174694')
                  ->setPaymentInterval(1),
                (new Contract())
                  ->setFee(14641)
                  ->setInsurer('Heidelberger Leben Service Management GmbH')
                  ->setGonettoContractNumber(234)
                  ->setMainRenewalDate(new \DateTime('2004-12-01'))
                  ->setInsuranceType('FLV')
                  ->setContractDate(new \DateTime('2018-09-19T09:51:17'))
                  ->setEndOfContract(new \DateTime('2009-12-01'))
                  ->setFinanceConsultContractNumber('00112395-02')
                  ->setPaymentInterval(2),
                (new Contract())
                  ->setFee(82.23)
                  ->setInsurer('Allianz Versicherungs-AG')
                  ->setGonettoContractNumber(345)
                  ->setMainRenewalDate(new \DateTime('2017-08-01'))
                  ->setInsuranceType('Unfall')
                  ->setContractDate(new \DateTime('2018-06-15T11:47:49'))
                  ->setEndOfContract(new \DateTime('2019-08-01'))
                  ->setFinanceConsultContractNumber('4864516/213')
                  ->setPaymentInterval(4),
                (new Contract())
                  ->setFee(427.60)
                  ->setInsurer('AUXILIA Allgemeine Rechtsschutz-Vers. AG')
                  ->setGonettoContractNumber(456)
                  ->setMainRenewalDate(new \DateTime('2005-03-01'))
                  ->setInsuranceType('Rechtsschutz')
                  ->setContractDate(new \DateTime('2018-06-20T10:39:12'))
                  ->setEndOfContract(new \DateTime('2019-03-01'))
                  ->setFinanceConsultContractNumber('1095494900')
                  ->setPaymentInterval(12),
                (new Contract())
                  ->setFee(74.97)
                  ->setInsurer('Die Haftpflichkasse VVaG')
                  ->setGonettoContractNumber(567)
                  ->setMainRenewalDate(new \DateTime('2018-05-29'))
                  ->setInsuranceType('Haftpflicht')
                  ->setContractDate(new \DateTime('2018-05-31T14:15:50'))
                  ->setEndOfContract(new \DateTime('2019-05-29'))
                  ->setFinanceConsultContractNumber('24972282')
                  ->setPaymentInterval(0),
              ]
            ),
          (new Customer())
            ->setEmail('erika.musterfrau@web.de')
            ->setFirstName('Erika')
            ->setLastName('Musterfrau')
            ->setCompany('Beispielfirma')
            ->setStreet('Besipielstr. 1')
            ->setZipCode(54321)
            ->setCity('Beispielstadt')
            ->setIban('DE02500105170137075030'),
        ];
    }
}
